<?php

/**
 * Adminhtml job content
 *
 * @category   Gpec
 * @package    Gpec_Job
 * @author     Gpec <contact@gpec.fr>
 */
class Gpec_Core_Block_Adminhtml_Search extends Mage_Adminhtml_Block_Template
{
    public function getResults()
    {

        $q = $this->_cleantString($this->getQuery());

        if (empty($q)) {
            return array();
        }
        /**
         * Get the resource model
         */
        $resource = Mage::getSingleton('core/resource');

        /**
         * Retrieve the read connection
         */
        $readConnection = $resource->getConnection('core_read');

        $query = "
            select adm.username as user_username,
            adm.user_id as user_id,
            adm.firstname as user_firstname,
            adm.email as user_email,
            adm.lastname as user_lastname,

            gpec_job.name as job_name,
            gpec_job.description as job_description,

            gpec_training.training_id as training_id,
            gpec_training.name as training_name,
            gpec_training.description as training_description,
            gpec_training.trainer as training_trainer,
            gpec_training.started_at as training_started_at,
            gpec_training.ended_at as training_ended_at,

            gpec_report.report_id as report_id,
            gpec_report.type_id as report_type_id,
            gpec_report.name as report_name,
            gpec_report.content as report_content

            from admin_user as adm
            left join gpec_job_user on adm.user_id = gpec_job_user.user_id
            left join gpec_job on gpec_job.job_id = gpec_job_user.job_id
            left join gpec_training_user on gpec_training_user.user_id = adm.user_id
            left join gpec_training on gpec_training.training_id = gpec_training_user.training_id
            left join gpec_report on gpec_report.user_id = adm.user_id
;
         ";

        $resultQuery = $readConnection->fetchAll($query);
        $users = array();

        foreach ($resultQuery as $r) {

            $users[$r['user_id']]['lastname'] = $r['user_lastname'];
            $users[$r['user_id']]['firstname'] = $r['user_firstname'];
            $users[$r['user_id']]['username'] = $r['user_username'];
            $users[$r['user_id']]['email'] = $r['user_email'];
            $users[$r['user_id']]['job'] = $r['job_name'];
            $users[$r['user_id']]['job_description'] = $r['job_description'];

            if (!is_null($r['report_name'])) {
                $users[$r['user_id']]['report'][$r['report_id']] = array(
                    'type' => Mage::getModel('gpec_report/report')->getType($r['report_type_id']),
                    'name' => $r['report_name'],
                    'content' => $r['report_content']
                );
            }

            if (!is_null($r['training_name'])) {
                $users[$r['user_id']]['training'][$r['training_id']] = array(
                    'name' => $r['training_name'],
                    'description' => $r['training_description'],
                    'trainer' => $r['training_trainer'],
                    'started_at' => date("d/m/Y", strtotime($r['training_started_at'])),
                    'ended_at' => date("d/m/Y", strtotime($r['training_ended_at']))
                );
            }
        }

        $result = array();

        foreach ($users as $userId => $u) {

            $haveToAdd = false;
            $toAdd = $u;

            $forceShowAll = false;

            if (strpos($this->_cleantString($u['lastname']), $q) !== false
                or strpos($this->_cleantString($u['lastname']), $q) !== false
                or strpos($this->_cleantString($u['firstname']), $q) !== false
                or strpos($this->_cleantString($u['username']), $q) !== false
                or strpos($this->_cleantString($u['email']), $q) !== false
                or strpos($this->_cleantString($u['job']), $q) !== false
                or strpos($this->_cleantString($u['job_description']), $q) !== false
            ) {
                $haveToAdd = true;
                $forceShowAll = true;
            }

            if (isset($u['report'])) {
                $toAdd['report'] = array();
                foreach ($u['report'] as $reportId => $report) {
                    if ((strpos($this->_cleantString($report['name']), $q) !== false
                            or strpos($this->_cleantString($report['content']), $q) !== false
                            or strpos($this->_cleantString($report['type']), $q) !== false
                        ) or $forceShowAll
                    ) {
                        $toAdd['report'][$reportId] = array(
                            'type' => $report['type'],
                            'name' => $report['name'],
                            'content' => $report['content']
                        );
                        $haveToAdd = true;
                    }
                }
            }

            if (isset($u['training'])) {
                $toAdd['training'] = array();
                foreach ($u['training'] as $trainingId => $training) {
                    if ((strpos($this->_cleantString($training['name']), $q) !== false
                            or strpos($this->_cleantString($training['description']), $q) !== false
                            or strpos($this->_cleantString($training['trainer']), $q) !== false
                        ) or $forceShowAll
                    ) {
                        $toAdd['training'][$trainingId] = array(
                            'name' => $training['name'],
                            'description' => $training['description'],
                            'trainer' => $training['trainer'],
                            'started_at' => $training['started_at'],
                            'ended_at' => $training['ended_at']
                        );
                        $haveToAdd = true;
                    }
                }
            }


            $adm = Mage::getModel('admin/user');
            $adm->setUserId($userId);

            $lastSkills = Mage::getResourceModel('admin/user')->getLastSkills($adm);


            if (isset($lastSkills['skills']) && !empty($lastSkills['skills'])) {

                if (($lastSkills['skills']) != "null") {

                    $skillDecoded = Mage::helper('core')->jsonDecode($lastSkills['skills']);

                    $toAdd['skill_updated'] = date("d/m/Y", strtotime($lastSkills['created_at']));

                    $skillCollection = Mage::getModel('gpec_skill/skill')->getCollection()
                        ->addFieldToFilter('skill_id', array('in' => array_keys($skillDecoded)));

                    $skillCollectionData = array();
                    foreach ($skillCollection as $s) {
                        $skillCollectionData[$s->getSkillId()] = array(
                            'category' => $s->getCategory(),
                            'name' => $s->getName(),
                            'description' => $s->getDescription(),
                        );
                    }

                    $toAdd['skills'] = array();
                    $mySkill = array();
                    foreach ($skillDecoded as $skillId => $skillData) {
                        $mySkill[$skillId] = array(
                            'category' => $skillCollectionData[$skillId]['category'],
                            'name' => $skillCollectionData[$skillId]['name'],
                            'description' => $skillCollectionData[$skillId]['description'],
                            'note' => $skillData['note'],
                            'comment' => $skillData['comment']
                        );
                    }

                    foreach ($mySkill as $skillId => $skillData) {
                        if ((strpos($this->_cleantString($skillData['category']), $q) !== false
                                or strpos($this->_cleantString($skillData['name']), $q) !== false
                                or strpos($this->_cleantString($skillData['description']), $q) !== false
                                or strpos($this->_cleantString($skillData['note']), $q) !== false
                                or strpos($this->_cleantString($skillData['comment']), $q) !== false
                            ) or $forceShowAll
                        ) {
                            $haveToAdd = true;
                            $toAdd['skills'][$skillId] = array(
                                'category' => $skillCollectionData[$skillId]['category'],
                                'name' => $skillCollectionData[$skillId]['name'],
                                'description' => $skillCollectionData[$skillId]['description'],
                                'note' => $skillData['note'],
                                'comment' => $skillData['comment']
                            );

                        }
                    }

                }

            }

            if ($haveToAdd) {
                $result[$userId] = $toAdd;
            }
        }

        return $result;

    }

    protected function _cleantString($str)
    {
        $str = strtr($str, 'ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝ', 'AAAAAACEEEEEIIIINOOOOOUUUUY');
        $str = strtr($str, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
        $str = trim(strtolower($str));
        return $str;
    }
}
