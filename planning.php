<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

ini_set('display_errors', 1);
if (version_compare(phpversion(), '5.2.0', '<')) {
    echo 'It looks like you have an invalid PHP version. Magento supports PHP 5.2.0 or newer';
    exit;
}

$magentoRootDir = getcwd();
$bootstrapFilename = $magentoRootDir . '/app/bootstrap.php';
$mageFilename = $magentoRootDir . '/app/Mage.php';

if (!file_exists($bootstrapFilename)) {
    echo 'Bootstrap file not found';
    exit;
}
if (!file_exists($mageFilename)) {
    echo 'Mage file not found';
    exit;
}
require $bootstrapFilename;
require $mageFilename;

if (!Mage::isInstalled()) {
    echo 'Application is not installed yet, please complete install wizard first.';
    exit;
}

//if (isset($_SERVER['MAGE_IS_DEVELOPER_MODE'])) {
Mage::setIsDeveloperMode(true);
//}


Mage::$headersSentThrowsException = false;
Mage::init('admin');
Mage::app()->loadAreaPart(Mage_Core_Model_App_Area::AREA_GLOBAL, Mage_Core_Model_App_Area::PART_EVENTS);
Mage::app()->loadAreaPart(Mage_Core_Model_App_Area::AREA_ADMINHTML, Mage_Core_Model_App_Area::PART_EVENTS);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Gestion comptabilité</title>
    <link rel="icon" href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/favicon.ico"
          type="image/x-icon"/>
    <link rel="shortcut icon" href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/favicon.ico"
          type="image/x-icon"/>

    <script type="text/javascript">
        var BLANK_URL = 'http://compta.nicolas-verhoye.com/js/blank.html';
        var BLANK_IMG = 'http://compta.nicolas-verhoye.com/js/spacer.gif';
        var BASE_URL = 'http://compta.nicolas-verhoye.com/index.php/adm/index/index/key/e4a0b377973bb0703d8cfa5f16f4a53d/';
        var SKIN_URL = 'http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/';
        var FORM_KEY = 'yho9LZcEbG2n74Wo';
    </script>

    <link rel="stylesheet" type="text/css" href="http://compta.nicolas-verhoye.com/js/calendar/calendar-win2k-1.css"/>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/reset.css" media="all"/>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/boxes.css" media="all"/>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/custom.css" media="all"/>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/css/jquery/jquery-ui.css" media="all"/>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/css/jquery/datepicker/ui.datepick.css"
          media="all"/>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/css/jquery/datepicker/ui-hot-sneaks.datepick.css"
          media="all"/>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/print.css" media="print"/>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/menu.css" media="screen, projection"/>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/prototype/prototype.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/prototype/window.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/scriptaculous/builder.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/scriptaculous/effects.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/scriptaculous/dragdrop.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/scriptaculous/controls.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/scriptaculous/slider.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/lib/ccard.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/prototype/validation.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/varien/js.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/translate.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/hash.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/events.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/loader.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/grid.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/tabs.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/form.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/accordion.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/tools.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/uploader.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/mage/adminhtml/product.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/calendar/calendar.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/calendar/calendar-setup.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/jquery/jquery.1.11.1.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/jquery/jquery.noConflict.js"></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript"
            src="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/lib/jquery/chart/chart.bar.js"></script>
    <script type="text/javascript"
            src="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/lib/jquery/jquery.plugin.js"></script>
    <script type="text/javascript"
            src="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/lib/jquery/jquery.datepick.js"></script>
    <script type="text/javascript"
            src="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/lib/jquery/jquery.datepick.ext.js"></script>
    <script type="text/javascript"
            src="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/lib/jquery/jquery.datepick-fr.js"></script>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/iestyles.css" media="all"/>
    <![endif]-->
    <!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/below_ie7.css" media="all"/>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/lib/ds-sleight.js" defer></script>
    <script type="text/javascript" src="http://compta.nicolas-verhoye.com/js/varien/iehover-fix.js"></script>
    <![endif]-->
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css"
          href="http://compta.nicolas-verhoye.com/skin/adminhtml/default/default/ie7.css" media="all"/>
    <![endif]-->


    <script type="text/javascript">
        Fieldset.addToPrefix(2);
    </script>


    <script type="text/javascript">
        //<![CDATA[
        enUS = {
            "m": {
                "wide": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                "abbr": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            }
        }; // en_US locale reference
        Calendar._DN = ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"]; // full day names
        Calendar._SDN = ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."]; // short day names
        Calendar._FD = 0; // First day of the week. "0" means display Sunday first, "1" means display Monday first, etc.
        Calendar._MN = ["janvier", "f\u00e9vrier", "mars", "avril", "mai", "juin", "juillet", "ao\u00fbt", "septembre", "octobre", "novembre", "d\u00e9cembre"]; // full month names
        Calendar._SMN = ["janv.", "f\u00e9vr.", "mars", "avr.", "mai", "juin", "juil.", "ao\u00fbt", "sept.", "oct.", "nov.", "d\u00e9c."]; // short month names
        Calendar._am = "AM"; // am/pm
        Calendar._pm = "PM";

        // tooltips
        Calendar._TT = {};
        Calendar._TT["INFO"] = "À propos du calendrier";

        Calendar._TT["ABOUT"] =
            "Sélecteur de date/heure DHTML\n" +
            "(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" +
            "Pour la visite de la dernière version : http://www.dynarch.com/projects/calendar/\n" +
            "Distribué sous licence GNU LGPL. Voir http://gnu.org/licenses/lgpl.html pour plus de détails." +
            "\n\n" +
            "Sélection de date :\n" +
            "- Utilisez les boutons \xab, \xbb pour sélectionner l'année\n" +
            "- Utilisez les boutons " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " pour sélectionner le mois\n" +
            "- Maintenez le bouton de la souris sur n'importe quel bouton ci-dessus pour une sélection rapide";
        Calendar._TT["ABOUT_TIME"] = "\n\n" +
            "Sélection de l'heure :\n" +
            "- Cliquez sur n'importe quelle partie de l'heure pour l'augmenter\n" +
            "- ou cliquez en maintenant la touche shift enfoncée pour l'augmenter\n" +
            "- ou cliquez et glissez pour une sélection plus rapide";

        Calendar._TT["PREV_YEAR"] = "Année précédente (maintenez pour le menu)";
        Calendar._TT["PREV_MONTH"] = "Mois précédent (maintenez pour le menu)";
        Calendar._TT["GO_TODAY"] = "Aller à aujourd'hui";
        Calendar._TT["NEXT_MONTH"] = "Mois suivant (maintenez pour le menu)";
        Calendar._TT["NEXT_YEAR"] = "Année prochaine (maintenez pour le menu)";
        Calendar._TT["SEL_DATE"] = "Sélectionner la date";
        Calendar._TT["DRAG_TO_MOVE"] = "Glisser pour déplacer";
        Calendar._TT["PART_TODAY"] = ' (' + "aujourd\u2019hui" + ')';

        // the following is to inform that "%s" is to be the first day of week
        Calendar._TT["DAY_FIRST"] = "Afficher d'abord %s";

        // This may be locale-dependent. It specifies the week-end days, as an array
        // of comma-separated numbers. The numbers are from 0 to 6: 0 means Sunday, 1
        // means Monday, etc.
        Calendar._TT["WEEKEND"] = "0,6";

        Calendar._TT["CLOSE"] = "Fermer";
        Calendar._TT["TODAY"] = "aujourd\u2019hui";
        Calendar._TT["TIME_PART"] = "Pour modifier la valeur, cliquez en maintenant la touche shift enfoncée ou glissez";

        // date formats
        Calendar._TT["DEF_DATE_FORMAT"] = "%e %b %Y";
        Calendar._TT["TT_DATE_FORMAT"] = "%e %B %Y";

        Calendar._TT["WK"] = "semaine";
        Calendar._TT["TIME"] = "Heure :";

        CalendarDateObject._LOCAL_TIMZEONE_OFFSET_SECONDS = 7200;
        CalendarDateObject._SERVER_TIMZEONE_SECONDS = 1460500625;

        //]]>
    </script>
    <style>body {
            overflow-y: scroll;
        }

        .notification-global {
            display: none
        }</style>
</head>

<body id="html-body" class=" adminhtml-calendar-index-index">


<?php $calendarCollection = Mage::getModel('compta_calendar/calendar')->getCollection(); ?>

<style>
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default{
        background: none !important;
    }
    .ui-datepicker-week-end {
        border:none !important;
    }

    .ui-state-active {
        border: 2px dashed #000 !important;
        background: #93c3cd url("/skin/adminhtml/default/default/images/jquery/ui/ui-bg_diagonals-small_50_93c3cd_40x40.png") 50% 50% repeat !important;
        font-weight: bold !important;
        color: #333333 !important;
    }

    <?php foreach($calendarCollection as $cal): ?>

        <?php $customer = Mage::getModel('compta_customer/customer')->load($cal->getCustomerId()); ?>

        <?php if($customer->getNom() == $_GET['u']): ?>
        .ui-datepicker-calendar td a.customer-<?php echo md5($customer->getNom()); ?> {
            background: orange !important;
        }
        <?php else: ?>
        .ui-datepicker-calendar td a.customer-<?php echo md5($customer->getNom()); ?> {
            background: #c0c0c0 !important;
        }
        <?php endif; ?>

    <?php endforeach; ?>

</style>

<?php if (!isset($_GET['u'])): ?>
    <div style="padding-left: 10%; padding-top:50px">
    <form action="/planning.php" method="get">
        <label for="u">IDENTIFIANT :</label>
        <input type="text" name="u" id="u"/>
        <input type="submit" />
    </form>
    </div>
<?php die; ?>
<?php else: ?>


    <br/><br/><br/>
    <div style="padding-left: 20%" id="timeslot_calendar"></div>
    <br/><br/><br/>
<?php endif; ?>



<script type="text/javascript">
jQuery(function() {

try {

    var calendar = [
        <?php foreach($calendarCollection as $calendar):?>
        <?php $customer = Mage::getModel('compta_customer/customer')->load($calendar->getCustomerId()); ?>
        {
            "customerId": "<?php echo $customer->getId(); ?>",
            "customerClass": "<?php echo md5($customer->getNom()); ?>",
            "dates": [
                <?php $dates = Mage::helper('core')->jsonDecode($calendar->getValues()); ?>
                <?php foreach($dates as $day => $nbHour):?>
                {"day": '<?php echo $day; ?>', "hour": <?php echo (string)$nbHour; ?>},
                <?php endforeach; ?>
            ]
        },
        <?php endforeach; ?>
    ];

    var daySelected = [];

    for (var i = 0; i < calendar.length; i++) {
        var obj = calendar[i];
    }

    jQuery('#timeslot_calendar').datepick({
        dateFormat: 'yyyy-mm-dd',
        altFormat: 'yyyy-mm-dd',
        altField: '#timeslot',
        monthsToShow: [3, 3],
        showOtherMonths: true,
        multiSelect: false,
        selectDefaultDate: false,
        firstDay: 1,
        renderer: jQuery.datepick.themeRollerRenderer,
        onShow: function () {
            for (var i = 0; i < calendar.length; i++) {
                var obj = calendar[i];
                if ((obj.dates).length) {

                    for (var d = 0; d < (obj.dates).length; d++) {
                        date = (obj.dates)[d].day;
                        hour = (obj.dates)[d].hour;

                        var yy = parseInt(date.substring(0,4));
                        var mm = parseInt(date.substring(5,7));
                        var dd = parseInt(date.substring(8,10));

                        foo = new Date();
                        foo.setYear(yy);
                        foo.setMonth(mm);
                        foo.setMonth(foo.getMonth() - 1);
                        foo.setDate(dd);
                        foo.setHours(12);
                        foo.setMinutes(0);
                        foo.setSeconds(0);

                        function getTimeStamp(strDate) {
                            var datum = Date.parse(strDate);
                            return datum;
                        }

                        timestamp = getTimeStamp(foo);

                        if (jQuery('td a.dp' + timestamp)) {
                            if (hour > 0) {
                                jQuery('td a.dp' + timestamp).addClass('customer-' + obj.customerClass);
                            }
                        }

                    }
                }
            }
        }
    });
} catch(e) {
    alert(e);
}
});
</script>


</body>