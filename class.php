<?php

class idlersConfig
{
    const PAGE_TITLE = 'My idlers';
    const PAGE_DESC = 'My idlers listing server, shared hosting and domains information and data.';

    const SRV_SORT_TYPE = 'HOSTNAME_ASC';//Server card sort type
    const SH_SORT_TYPE = 'HOSTNAME_ASC';//Shared hosting sort type
    const DC_SORT_TYPE = 'HOSTNAME_ASC';//Domains sort type
    //Options: PRICE_DESC, PRICE_ASC, DUE_DESC, DUE_ASC, OWNED_SINCE_DESC,OWNED_SINCE_ASC, HOSTNAME_DESC & HOSTNAME_ASC

    const DB_HOSTNAME = '127.0.0.1';
    const DB_NAME = 'idlers';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';
}

class elementHelpers extends idlersConfig
{
    //Minimizes lines used + opening and closing of <?PHP tag
    protected function tagOpen(string $tag = 'div', string $class = '', string $id = '')
    {
        if (empty($class) && empty($id)) {
            $this->outputString("<$tag>");
        } elseif (empty($class) && !empty($id)) {
            $this->outputString("<$tag id='$id'>");
        } elseif (!empty($class) && empty($id)) {
            $this->outputString("<$tag class='$class'>");
        } else {
            $this->outputString("<$tag class='$class' id='$id'>");
        }
    }

    protected function tagClose(string $tag = 'div', int $amount = 1)
    {
        for ($i = 1; $i <= $amount; $i++) {
            $this->outputString("</$tag>");
        }
    }

    protected function outputString(string $string)
    {
        echo $string;
    }

    protected function collapseButton(string $text, string $href, string $id = 'collapseId', string $class = 'btn btn-main collapse-btn', bool $expanded = false)
    {
        ($expanded) ? $ex = "true" : $ex = "false";
        $this->outputString('<a class="' . $class . '" data-toggle="collapse" href="#' . $href . '" id="' . $id . '" role="button" aria-expanded="' . $ex . '">' . $text . '</a>');
    }

    protected function HTMLphrase(string $element = 'p', string $class = '', string $text = '', string $id = '')
    {
        if (empty($class)) {
            if (empty($id)) {
                $this->tagOpen($element);
            } else {
                $this->tagOpen($element, '', $id);
            }
        } else {
            if (empty($id)) {
                $this->tagOpen($element, $class);
            } else {
                $this->tagOpen($element, $class, $id);
            }
        }
        $this->outputString($text);
        $this->tagClose($element);
    }

    protected function colOpen(string $class = 'col-12')
    {
        $this->tagOpen('div', $class);
    }

    protected function rowColOpen(string $row_class = 'row', string $col_class = 'col-12')
    {
        $this->tagOpen('div', $row_class);
        $this->tagOpen('div', $col_class);
    }

    protected function textInput(string $name_id, string $value = '', string $class = 'form-control', bool $required = false, int $min_length = 0, int $max_length = 124)
    {
        (empty($value)) ? $val = '' : $val = " value='$value'";
        ($required) ? $req = 'required' : $req = '';
        $this->outputString("<input type='text' id='$name_id' name='$name_id' class='$class' min-length='$min_length' max-length='$max_length'$val $req>");
    }

    protected function numberInput(string $name_id, string $value = '', string $class = 'form-control', bool $required = false, int $min = 0, int $max = 9999, string $step = 'any')
    {
        (empty($value)) ? $val = '' : $val = " value='$value'";
        ($required) ? $req = 'required' : $req = '';
        $this->outputString("<input type='number' id='$name_id' name='$name_id' class='$class' min='$min' max='$max' step='$step'$val $req>");
    }

    protected function hiddenInput(string $name_id, string $value = '')
    {
        (empty($value)) ? $val = '' : $val = " value='$value'";
        $this->outputString("<input type='hidden' id='$name_id' name='$name_id' $val>");
    }

    protected function submitInput(string $text, string $id = 'submitInput', string $class = 'btn')
    {
        $this->outputString("<input type='submit' class='$class' id='$id' value='$text'>");
    }

    protected function inputPrepend(string $text)
    {
        $this->outputString('<div class="input-group-prepend"><span class="input-group-text">' . $text . '</span></div>');
    }

    protected function tagsInput(string $name_id, string $class = 'form-control')
    {
        $this->outputString("<input type='text' id='$name_id' name='$name_id' class='$class' data-role='tagsinput'>");
    }

    protected function selectElement(string $name_id, string $class = 'form-control')
    {
        $this->outputString("<select class='$class' id='$name_id' name='$name_id'>");
    }

    protected function selectOption(string $text, string $value, bool $selected = false)
    {
        ($selected) ? $sel = ' selected' : $sel = '';
        $this->outputString("<option value='$value'$sel>$text</option>");
    }

    protected function checkInput(string $text, string $name_id, string $input_class = 'form-check-input', string $label_class = 'form-check-label')
    {
        $this->tagOpen("div", "form-check");
        $this->outputString("<input class='$input_class' type='checkbox' id='$name_id' name='$name_id'>");
        $this->outputString("<label class='$label_class' for='$name_id'>");
        $this->outputString("<b>$text</b>");
        $this->tagClose("label");
        $this->tagClose("div");
    }

    protected function navTabs(array $names, array $links)
    {
        $this->tagOpen("ul", "nav nav-tabs");
        $counter = 0;
        foreach ($names as $tab) {
            $this->tagOpen("li", "nav-item");
            if ($counter == 0) {
                $this->outputString('<a class="nav-link active" data-toggle="tab" href="' . $links[$counter] . '">' . $tab . '</a>');
            } else {
                $this->outputString('<a class="nav-link" data-toggle="tab" href="' . $links[$counter] . '">' . $tab . '</a>');
            }
            $this->tagClose("li");
            $counter++;
        }
        $this->tagClose("ul");
    }

    protected function tableHeader(array $headers)
    {
        $this->tagOpen('div', 'table-responsive');
        $this->outputString("<table class='table table-striped table-bordered table-sm' id='orderTable'>");
        $this->tagOpen('thead');
        $this->tagOpen('tr');
        foreach ($headers as $th) {
            $this->outputString("<th>$th</th>");
        }
        $this->outputString('</tr></thead><tbody>');
    }

    protected function virtSelectOptions()
    {
        $this->selectOption('KVM', 'KVM', true);
        $this->selectOption('OVZ', 'OVZ');
        $this->selectOption('DEDI', 'DEDI');
        $this->selectOption('LXC', 'LXC');
    }

    protected function sharedHostingTypeOptions()
    {
        $this->selectOption('ApisCP', 'ApisCP');
        $this->selectOption('Centos', 'Centos');
        $this->selectOption('cPanel', 'cPanel', true);
        $this->selectOption('Direct Admin', 'Direct Admin');
        $this->selectOption('Webmin', 'Webmin');
        $this->selectOption('Moss', 'Moss');
        $this->selectOption('Other', 'Other');
        $this->selectOption('Plesk', 'Plesk');
        $this->selectOption('Run cloud', 'Run cloud');
        $this->selectOption('Vesta CP', 'Vesta CP');
        $this->selectOption('Virtual min', 'Virtual min');
    }

    protected function termSelectOptions()
    {
        $this->selectOption('Monthly', '1', true);
        $this->selectOption('Quarterly', '2');
        $this->selectOption('Half annual (half year)', '3');
        $this->selectOption('Annual (yearly)', '4');
        $this->selectOption('Biennial (2 years)', '5');
        $this->selectOption('Triennial (3 years)', '6');
    }

    protected function domainTermSelectOptions()
    {
        $this->selectOption('Annual (yearly)', '4', true);
        $this->selectOption('Biennial (2 years)', '5');
        $this->selectOption('Triennial (3 years)', '6');
    }

    protected function CurrencySelectOptions()
    {
        $this->selectOption('AUD', 'AUD');
        $this->selectOption('USD', 'USD', true);
        $this->selectOption('GBP', 'GBP');
        $this->selectOption('EUR', 'EUR');
        $this->selectOption('NZD', 'NZD');
        $this->selectOption('JPY', 'JPY');
        $this->selectOption('CAD', 'CAD');
    }

    protected function OsSelectOptions()
    {
        $this->selectOption('Centos 7', '1');
        $this->selectOption('Centos 8', '2');
        $this->selectOption('Centos', '3');
        $this->selectOption('Debian 9', '4');
        $this->selectOption('Debian 10', '5');
        $this->selectOption('Debian', '6');
        $this->selectOption('Fedora 32', '7');
        $this->selectOption('Fedora 33', '8');
        $this->selectOption('Fedora', '9');
        $this->selectOption('FreeBSD 11.4', '10');
        $this->selectOption('FreeBSD 12.1', '11');
        $this->selectOption('FreeBSD', '12');
        $this->selectOption('OpenBSD 6.7', '13');
        $this->selectOption('OpenBSD 6.8', '14');
        $this->selectOption('OpenBSD', '15');
        $this->selectOption('Ubuntu 16.04', '16');
        $this->selectOption('Ubuntu 18.04', '17');
        $this->selectOption('Ubuntu 20.04', '18');
        $this->selectOption('Ubuntu 20.10', '19');
        $this->selectOption('Ubuntu', '20');
        $this->selectOption('Windows Server 2008', '21');
        $this->selectOption('Windows Server 2012', '22');
        $this->selectOption('Windows Server 2016', '23');
        $this->selectOption('Windows Server 2019', '24');
        $this->selectOption('Windows 10', '25');
        $this->selectOption('Custom', '26');
        $this->selectOption('Other', '27');
    }

}

class helperFunctions extends elementHelpers
{
    protected function genID(int $length = 8)
    {//Returns an id string
        $character_pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $char_length = strlen($character_pool);
        $the_string = '';
        for ($i = 0; $i < $length; $i++) {
            $the_string .= $character_pool[mt_rand(0, $char_length - 1)];
        }
        return $the_string;
    }

    protected function mhzToGhz(string $mhz, int $decimals = 2)
    {
        return number_format(floatval(($mhz / 1000)), $decimals);
    }

    protected function paymentTerm(int $term)
    {
        if ($term == 1) {
            return "p/m";
        } elseif ($term == 2) {
            return "p/qtr";
        } elseif ($term == 3) {
            return "p/hy";
        } elseif ($term == 4) {
            return "p/y";
        } elseif ($term == 5) {
            return "p/2y";
        } elseif ($term == 6) {
            return "p/3y";
        } else {
            return "NULL";
        }
    }

    protected function costAsPerMonth(string $cost, int $term)
    {
        if ($term == 1) {
            return $cost;
        } elseif ($term == 2) {
            return ($cost / 3);
        } elseif ($term == 3) {
            return ($cost / 6);
        } elseif ($term == 4) {
            return ($cost / 12);
        } elseif ($term == 5) {
            return ($cost / 24);
        } elseif ($term == 6) {
            return ($cost / 36);
        } else {
            return $cost;
        }
    }

    protected function convertToUSD(string $amount, string $convert_from)
    {
        if ($convert_from == 'AUD') {
            return (0.76 * $amount);
        } elseif ($convert_from == "USD") {
            return $amount;
        } elseif ($convert_from == "GBP") {
            return (1.35 * $amount);
        } elseif ($convert_from == "EUR") {
            return (1.23 * $amount);
        } elseif ($convert_from == "NZD") {
            return (0.72 * $amount);
        } elseif ($convert_from == "JPY") {
            return (0.0097 * $amount);
        } elseif ($convert_from == "CAD") {
            return (0.78 * $amount);
        } else {
            return "";
        }
    }

    protected function osIntToIcon(int $os)
    {
        if ($os <= 3) {//Centos
            return "<i class='fab fa-centos os-icon'></i>";
        } elseif ($os > 3 && $os <= 6) {//Debain
            return "<i class='fab fa-linux os-icon'></i>";
        } elseif ($os > 6 && $os < 10) {//Fedora
            return "<i class='fab fa-fedora os-icon'></i>";
        } elseif ($os > 10 && $os < 13) {//FreeBSD
            return "<i class='fab fa-linux os-icon'></i>";
        } elseif ($os > 13 && $os < 16) {//OpenBSD
            return "<i class='fab fa-linux os-icon'></i>";
        } elseif ($os > 15 && $os < 21) {//Ubuntu
            return "<i class='fab fa-ubuntu os-icon'></i>";
        } elseif ($os > 20 && $os < 26) {//Windows
            return "<i class='fab fa-windows os-icon'></i>";
        } else {//OTHER ISO CUSTOM etc
            return "<i class='fas fa-compact-disc os-icon'></i>";
        }
    }

    protected function osIntToString(int $os)
    {
        if ($os == "1") {
            return "CentOS 7";
        } elseif ($os == "2") {
            return "CentOS 8";
        } elseif ($os == "3") {
            return "CentOS";
        } elseif ($os == "4") {
            return "Debian 9";
        } elseif ($os == "5") {
            return "Debian 10";
        } elseif ($os == "6") {
            return "Debian";
        } elseif ($os == "7") {
            return "Fedora 32";
        } elseif ($os == "8") {
            return "Fedora 33";
        } elseif ($os == "9") {
            return "Fedora";
        } elseif ($os == "10") {
            return "FreeBSD 11.4";
        } elseif ($os == "11") {
            return "FreeBSD 12.1";
        } elseif ($os == "12") {
            return "FreeBSD";
        } elseif ($os == "13") {
            return "OpenBSD 6.7";
        } elseif ($os == "14") {
            return "OpenBSD 6.8";
        } elseif ($os == "15") {
            return "OpenBSD";
        } elseif ($os == "16") {
            return "Ubuntu 16.04";
        } elseif ($os == "17") {
            return "Ubuntu 18.04";
        } elseif ($os == "18") {
            return "Ubuntu 20.04";
        } elseif ($os == "19") {
            return "Ubuntu 20.10";
        } elseif ($os == "20") {
            return "Ubuntu";
        } elseif ($os == "21") {
            return "Windows Server 2008";
        } elseif ($os == "22") {
            return "Windows Server 2012";
        } elseif ($os == "23") {
            return "Windows Server 2016";
        } elseif ($os == "24") {
            return "Windows Server 2019";
        } elseif ($os == "25") {
            return "Windows 10";
        } elseif ($os == "26") {
            return "Custom";
        } elseif ($os == "27") {
            return "Other";
        } else {
            return "Unknown";
        }
    }

    protected function floatValue(string $string)
    {//Keeps only numbers and . AKA a float
        return preg_replace('/[^0-9,.]/', '', trim($string));
    }

    protected function intValue(string $string)
    {//Keeps only numbers AKA an int
        return preg_replace('/[^0-9]/', '', trim($string));
    }

    protected function removeFloat(string $string)
    {//Removes float from a string
        return ltrim(preg_replace('/[^A-Za-z\-,.]/', '', $string), '.');
    }

    protected function trimRemoveR(string $string)
    {//Removes \r and does a trim()
        return trim(str_replace("\r", '', $string));
    }

    protected function datatype(string $string)
    {//Formats data type (ram and disk)
        if (strpos($string, 'M') !== false) {
            return 'MB';//Megabytes
        } elseif (strpos($string, 'G') !== false) {
            return 'GB';//Gigabytes
        } elseif (strpos($string, 'K') !== false) {
            return 'KB';//Kilobytes
        } elseif (strpos($string, 'T') !== false) {
            return 'TB';//TeraBytes
        } elseif (strpos($string, 'B') !== false) {
            return 'BT';//Bytes
        }
    }

    public function GBtoMB(string $gb)
    {//Gigabyte to Megabyte conversion
        return floatval(($gb * 1024));
    }

    protected function TBtoGB(string $tb)
    {//Terabyte to Gigabyte conversion
        return floatval(($tb * 1024));
    }

    protected function GBpstoMBps(string $gbps, bool $format = false)
    {//Gigabits to Megabits
        $gbps = (float)$gbps;
        if ($format) {
            return floatval(number_format(($gbps * 1000), 3));
        } else {
            return floatval(($gbps * 1000));
        }
    }

    protected function yabsSpeedLoc(array $data)
    {//Formats YABs speed test provider and location as array
        if ($data[1] == '|') {
            $provider = $data[0];
        } else {
            $provider = $data[0] . ' ' . $data[1];
        }
        if ($data[2] !== '|') {
            $location = $data[2] . ' ' . str_replace(',', '', $data[3]);
        } else {
            $location = $data[3] . ' ' . str_replace(',', '', $data[4]);
        }
        return array('provider' => $provider, 'location' => $location);
    }

    protected function yabsSpeedValues(array $data)
    {//Formats YABs speed test for speed value and type as array
        $data = explode('|', implode($data));
        if ($data[2] == 'busy') {
            $send = $send_type = NULL;
        } else {
            $send = floatval($data[2]);
            if ($this->removeFloat($data[2]) == 'Mbitssec') {
                $send_type = "MBps";
            } elseif ($this->removeFloat($data[2]) == 'Gbitssec') {
                $send_type = "GBps";
            } elseif ($this->removeFloat($data[2]) == 'Kbitssec') {
                $send_type = "KBps";
            } else {
                $send_type = $this->removeFloat($data[2]);
            }
        }
        if ($data[3] == 'busy') {
            $receive = $receive_type = NULL;
        } else {
            $receive = floatval($data[3]);
            if ($this->removeFloat($data[3]) == 'Mbitssec') {
                $receive_type = "MBps";
            } elseif ($this->removeFloat($data[3]) == 'Gbitssec') {
                $receive_type = "GBps";
            } elseif ($this->removeFloat($data[3]) == 'Kbitssec') {
                $receive_type = "KBps";
            } else {
                $receive_type = $this->removeFloat($data[3]);
            }
        }
        return array('send' => $send, 'send_type' => $send_type, 'receive' => $receive, 'receive_type' => $receive_type);
    }

    protected function diskSpeedAsMbps(string $type, string $value)
    {//If value type GB/s convert to MB/s
        if ($type == "GB/s") {
            return $this->GBpstoMBps($value);
        } else {
            return $value;
        }
    }

    protected function networkSpeedAsMbps(string $type, string $value)
    {//If value type GBps convert to MB/s
        if ($type == "GBps") {
            return $this->GBpstoMBps($value);
        } else {
            return $value;
        }
    }

    protected function intToYesNo(int $int)
    {// 1 = Yes, 0 = No
        if ($int == 1) {
            return "Yes";
        } elseif ($int == 0) {
            return "No";
        } else {
            return $int;
        }
    }

    protected function saveYABS($content, string $filename)
    {
        return file_put_contents("yabs/$filename", $content);
    }

    protected function daysAway(string $ahead_date)
    {
        $today = new DateTime("now");
        $date = new DateTime($ahead_date);
        return $date->diff($today)->format("%a");
    }
}

class idlers extends helperFunctions
{
    protected function dbConnect()
    {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
        return new PDO("mysql:host=" . self::DB_HOSTNAME . ";dbname=" . self::DB_NAME . ";charset=utf8mb4", self::DB_USERNAME, self::DB_PASSWORD, $options);
    }

    protected function pageHead(string $title = 'Page Title')
    {//Echo output because it breaks formatting in PHPstorm if closing + opening PHP tags
        $this->outputString("<html lang='en'>");
        $this->tagOpen("head");
        $this->outputString("<title>" . self::PAGE_TITLE . "</title>");
        $this->outputString("<meta charset='utf-8'>");
        $this->outputString("<meta name='viewport' content='width=device-width, initial-scale=1'>");
        $this->outputString("<meta name='description' content='" . self::PAGE_DESC . "'>");
        $this->outputString("<link rel='shortcut icon' type='image/x-icon' href='assets/favicon.ico' />");
        $this->outputString("<link rel='stylesheet' href='assets/css/style.css'/>");
        $this->tagClose("head");
        $this->tagOpen("body");
        $this->tagOpen("div", "container");
    }

    protected function pageContents()
    {
        $this->navTabs(array('Services', 'Add', 'Order', 'Info', 'Search'), array('#services', '#add_server', '#order', '#info', '#search'));
        $this->outputString('<div id="myTabContent" class="tab-content">');
        $this->outputString('<div class="tab-pane server-cards fade active show" id="services">');
        $this->serverCards();
        $this->sharedHostingCards();
        $this->domainCards();
        $this->tagClose('div');
        $this->outputString('<div class="tab-pane fade" id="add_server">');
        //BTN Bar
        $this->rowColOpen('row text-center', 'col-12 btn-bar-col');
        $this->outputString('<div class="btn-group btn-group-toggle" data-toggle="buttons">');
        $this->outputString('<label class="btn btn-main btn-bar active">');
        $this->outputString('<input type="radio" name="options" id="addServerBTN" autocomplete="off" checked>Add server</label>');
        $this->outputString('<label class="btn btn-main btn-bar">');
        $this->outputString('<input type="radio" name="options" id="addServerNoYabsBTN" autocomplete="off">Add server no YABs</label>');
        $this->outputString('<label class="btn btn-main btn-bar">');
        $this->outputString('<input type="radio" name="options" id="addSharedHostingBTN" autocomplete="off">Add shared hosting</label>');
        $this->outputString('<label class="btn btn-main btn-bar">');
        $this->outputString('<input type="radio" name="options" id="addDomainBTN" autocomplete="off">Add Domain</label>');
        $this->tagClose('div', 3);

        $this->tagOpen('div', 'collapse show', 'addServer');
        $this->addVPSFormYabs();
        $this->tagClose('div');
        $this->tagOpen('div', 'collapse', 'addServerNoYabs');
        $this->addVPSForm();
        $this->tagClose('div');
        $this->tagOpen('div', 'collapse', 'addSharedHosting');
        $this->addSharedHostingForm();
        $this->tagClose('div');
        $this->tagOpen('div', 'collapse', 'addDomain');
        $this->addDomainForm();
        $this->tagClose('div', 2);

        $this->outputString('<div class="tab-pane fade" id="order">');
        $this->orderForm();
        $this->tagClose('div');

        $this->outputString('<div class="tab-pane fade" id="info">');
        $this->tagClose('div');

        $this->outputString('<div class="tab-pane fade" id="search">');
        $this->searchDiv();
        $this->tagClose('div', 2);

        $this->editServerModal();
        $this->editSharedHostingModal();
        $this->editDomainModal();

        $this->outputString('<div class="modal fade" id="viewMoreServerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">');
        $this->outputString('<div class="modal-dialog" role="document">');
        $this->outputString('<div class="modal-content" id="viewMoreModalBody">');
        $this->tagClose('div', 3);

        $this->outputString('<div class="modal fade" id="yabsModal" tabindex="-1" role="dialog" aria-labelledby="yabsmodalview" aria-hidden="true">');
        $this->outputString('<div class="modal-dialog modal-lg" role="document">');
        $this->outputString('<div class="modal-content text-center">');
        $this->tagOpen('div', 'modal-header');
        $this->outputString('<h4 class="modal-title w-100" id="yabs_hostname_header"></h4>');
        $this->outputString('<button type="button" class="close" data-dismiss="modal" aria-label="Close">');
        $this->outputString('<span aria-hidden="true">&times;</span>');
        $this->tagClose('button');
        $this->tagClose('div');
        $this->tagOpen('div', 'modal-body', 'yabsModalBody');
        $this->tagClose('div', 4);

        $this->outputString('<div class="modal fade" id="viewMoreModalSharedHosting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">');
        $this->outputString('<div class="modal-dialog" role="document">');
        $this->outputString('<div class="modal-content" id="viewMoreSharedHostingModalBody">');
        $this->tagClose('div', 3);

        $this->outputString('<div class="modal fade" id="viewMoreModalDomain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">');
        $this->outputString('<div class="modal-dialog" role="document">');
        $this->outputString('<div class="modal-content" id="viewMoreDomainModalBody">');
        $this->tagClose('div', 3);
    }

    protected function getProvider(int $provider)
    {
        $select = $this->dbConnect()->prepare("SELECT `name` FROM `providers` WHERE `id` = ? LIMIT 1;");
        $select->execute([$provider]);
        $row = $select->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {//Yes
            return $row['name'];
        } else {//NO
            return null;
        }
    }

    protected function getLocation(int $location)
    {
        $select = $this->dbConnect()->prepare("SELECT `name` FROM `locations` WHERE `id` = ? LIMIT 1;");
        $select->execute([$location]);
        $row = $select->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {//Yes
            return $row['name'];
        } else {//NO
            return null;
        }
    }

    public function serverDetails(string $id)
    {
        $select = $this->dbConnect()->prepare("SELECT id, hostname, location, provider, ipv4, ipv6, `cpu`, cpu_type, cpu_freq, ram, ram_type, swap, swap_type, `disk`, disk_type, bandwidth, bandwidth_type, gb5_single, gb5_multi, gb5_id, aes_ni, amd_v, is_dedicated, is_cpu_dedicated, was_special, os, still_have, DATE_FORMAT(`owned_since`, '%M %Y') as owned_since FROM `servers` WHERE `id` = ? LIMIT 1;");
        $select->execute([$id]);
        $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
        return json_encode($data);
    }

    public function serverData(string $id)
    {
        $select = $this->dbConnect()->prepare("SELECT `has_yabs`, `has_st` FROM `servers` WHERE `id` = ? LIMIT 1;");
        $select->execute([$id]);
        $row = $select->fetch();
        if ($row['has_yabs'] == 1 && $row['has_st'] == 1) {
            $select = $this->dbConnect()->prepare("
              SELECT servers.id as server_id,hostname,ipv4,ipv6,`cpu`,cpu_type,cpu_freq,ram,ram_type,swap,swap_type,`disk`,disk_type,bandwidth,bandwidth_type,gb5_single,gb5_multi,gb5_id,aes_ni,amd_v,
              is_dedicated,is_cpu_dedicated,was_special,os,ssh_port,still_have,tags,notes,virt,has_yabs,has_st,ns1,ns2,DATE_FORMAT(`owned_since`, '%M %Y') as owned_since, `owned_since` as owned_since_raw, `4k`,`4k_type`,`64k`,`64k_type`,`512k`,`512k_type`,`1m`,`1m_type`,
              loc.name as location,send,send_type,recieve,recieve_type,price,currency,term,as_usd,per_month,next_dd,pr.name as provider
              FROM servers INNER JOIN disk_speed ds on servers.id = ds.server_id
              INNER JOIN speed_tests st on servers.id = st.server_id INNER JOIN locations loc on servers.location = loc.id
              INNER JOIN providers pr on servers.provider = pr.id INNER JOIN pricing on servers.id = pricing.server_id WHERE servers.id = ? LIMIT 1;");
            $select->execute([$id]);
            $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
            $sel_st = $this->dbConnect()->prepare("SELECT `location`, `send`, `send_type`, `recieve`, `recieve_type` FROM `speed_tests` WHERE `server_id` = ? ORDER BY `datetime` DESC LIMIT 8;");
            $sel_st->execute([$id]);
            $speed_tests = $sel_st->fetchAll(PDO::FETCH_ASSOC);
            $final = array_merge($speed_tests, $data);
            return json_encode($final);
        } elseif ($row['has_yabs'] == 1 && $row['has_st'] == 0) {
            $select = $this->dbConnect()->prepare("
              SELECT servers.id as server_id,hostname,ipv4,ipv6,`cpu`,cpu_type,cpu_freq,ram,ram_type,swap,swap_type,`disk`,disk_type,bandwidth,bandwidth_type,gb5_single,gb5_multi,gb5_id,aes_ni,amd_v,
              is_dedicated,is_cpu_dedicated,was_special,os,ssh_port,still_have,tags,notes,virt,has_yabs,has_st,ns1,ns2,DATE_FORMAT(`owned_since`, '%M %Y') as owned_since, `owned_since` as owned_since_raw, `4k`,`4k_type`,`64k`,`64k_type`,`512k`,`512k_type`,`1m`,`1m_type`,
              loc.name as location,price,currency,term,as_usd,per_month,next_dd,pr.name as provider
              FROM servers INNER JOIN disk_speed ds on servers.id = ds.server_id
            INNER JOIN locations loc on servers.location = loc.id
              INNER JOIN providers pr on servers.provider = pr.id INNER JOIN pricing on servers.id = pricing.server_id WHERE servers.id = ? LIMIT 1;");
            $select->execute([$id]);
            $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
            return json_encode($data);
        } else {
            $select = $this->dbConnect()->prepare("
               SELECT servers.id as server_id,hostname,ipv4,ipv6,`cpu`,cpu_type,cpu_freq,ram,ram_type,swap,swap_type,`disk`,disk_type,
               bandwidth,bandwidth_type,gb5_single,gb5_multi,gb5_id,aes_ni,amd_v,is_dedicated,is_cpu_dedicated,was_special,os,ssh_port,still_have,tags,notes,virt,has_yabs,ns1,ns2,
               DATE_FORMAT(`owned_since`, '%M %Y') as owned_since,loc.name as location,price,currency,term,as_usd,per_month,next_dd,pr.name as provider
               FROM servers INNER JOIN locations loc on servers.location = loc.id
               INNER JOIN providers pr on servers.provider = pr.id INNER JOIN pricing on servers.id = pricing.server_id WHERE servers.id = ? LIMIT 1;");
            $select->execute([$id]);
            $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
            return json_encode($data);
        }
    }

    public function sharedHostingData(string $id)
    {
        $select = $this->dbConnect()->prepare("
               SELECT shared_hosting.id as server_id, domain, domains_limit, emails, disk, disk_type, disk_as_gb, ftp, db, bandwidth, provider, location, was_special,
                      still_have, type, `owned_since` as owned_since_raw, DATE_FORMAT(`owned_since`, '%M %Y') as owned_since,loc.name as location,price,currency,term,as_usd,per_month,next_dd,pr.name as provider
               FROM shared_hosting INNER JOIN locations loc on shared_hosting.location = loc.id
               INNER JOIN providers pr on shared_hosting.provider = pr.id INNER JOIN pricing on shared_hosting.id = pricing.server_id WHERE shared_hosting.id = ? LIMIT 1;");
        $select->execute([$id]);
        $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
        return json_encode($data);
    }

    public function domainData(string $id)
    {
        $select = $this->dbConnect()->prepare("
           SELECT domains.id as server_id, domain, attached_to, ns1, ns2, still_have, `owned_since` as owned_since_raw, DATE_FORMAT(`owned_since`, '%M %Y') as owned_since,price,currency,term,as_usd,per_month,next_dd,pr.name as provider
           FROM domains INNER JOIN providers pr on domains.provider = pr.id INNER JOIN pricing on domains.id = pricing.server_id WHERE domains.id = ? LIMIT 1;");
        $select->execute([$id]);
        $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
        return json_encode($data);
    }

    protected function serverCards()
    {
        if (self::SRV_SORT_TYPE == 'HOSTNAME_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers` ORDER BY `hostname` DESC;");
        } elseif (self::SRV_SORT_TYPE == 'HOSTNAME_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers` ORDER BY `hostname`;");
        } elseif (self::SRV_SORT_TYPE == 'OWNED_SINCE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers` ORDER BY `owned_since` DESC;");
        } elseif (self::SRV_SORT_TYPE == 'OWNED_SINCE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers` ORDER BY `owned_since`;");
        } elseif (self::SRV_SORT_TYPE == 'PRICE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers` INNER JOIN `pricing` ON servers.id = pricing.server_id ORDER BY `as_usd` DESC;");
        } elseif (self::SRV_SORT_TYPE == 'PRICE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers` INNER JOIN `pricing` ON servers.id = pricing.server_id ORDER BY `as_usd`;");
        } elseif (self::SRV_SORT_TYPE == 'DUE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers` INNER JOIN `pricing` ON servers.id = pricing.server_id ORDER BY `next_dd` DESC;");
        } elseif (self::SRV_SORT_TYPE == 'DUE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers` INNER JOIN `pricing` ON servers.id = pricing.server_id ORDER BY `next_dd`;");
        } else {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `servers`;");
        }
        $select->execute();
        $count = $select->rowCount();
        if ($count > 0) {
            $this->HTMLPhrase('h4', 'card-section-header', 'Servers <span class="object-count">' . $count . '</span>');
        }
        $this->tagOpen('div', 'row');
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $this->vpsCard($row['id']);
        }
        $this->tagClose('div');
    }

    protected function sharedHostingCards()
    {
        if (self::SH_SORT_TYPE == 'DOMAIN_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting` ORDER BY `domain` DESC;");
        } elseif (self::SH_SORT_TYPE == 'DOMAIN_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting` ORDER BY `domain`;");
        } elseif (self::SH_SORT_TYPE == 'OWNED_SINCE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting` ORDER BY `owned_since` DESC;");
        } elseif (self::SH_SORT_TYPE == 'OWNED_SINCE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting` ORDER BY `owned_since`;");
        } elseif (self::SH_SORT_TYPE == 'PRICE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting` INNER JOIN `pricing` ON shared_hosting.id = pricing.server_id ORDER BY `as_usd` DESC;");
        } elseif (self::SH_SORT_TYPE == 'PRICE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting` INNER JOIN `pricing` ON shared_hosting.id = pricing.server_id ORDER BY `as_usd`;");
        } elseif (self::SH_SORT_TYPE == 'DUE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting` INNER JOIN `pricing` ON shared_hosting.id = pricing.server_id ORDER BY `next_dd` DESC;");
        } elseif (self::SH_SORT_TYPE == 'DUE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting` INNER JOIN `pricing` ON shared_hosting.id = pricing.server_id ORDER BY `next_dd`;");
        } else {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `shared_hosting`;");
        }
        $select->execute();
        $count = $select->rowCount();
        if ($count > 0) {
            $this->HTMLPhrase('h4', 'card-section-header', 'Shared hosting <span class="object-count">' . $count . '</span>');
        }
        $this->tagOpen('div', 'row');
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $this->SharedHostingCard($row['id']);
        }
        $this->tagClose('div');
    }

    protected function domainCards()
    {
        if (self::DC_SORT_TYPE == 'DOMAIN_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains` ORDER BY `domain` DESC;");
        } elseif (self::DC_SORT_TYPE == 'DOMAIN_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains` ORDER BY `domain`;");
        } elseif (self::DC_SORT_TYPE == 'OWNED_SINCE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains` ORDER BY `owned_since` DESC;");
        } elseif (self::DC_SORT_TYPE == 'OWNED_SINCE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains` ORDER BY `owned_since`;");
        } elseif (self::DC_SORT_TYPE == 'PRICE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains` INNER JOIN `pricing` ON domains.id = pricing.server_id ORDER BY `as_usd` DESC;");
        } elseif (self::DC_SORT_TYPE == 'PRICE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains` INNER JOIN `pricing` ON domains.id = pricing.server_id ORDER BY `as_usd`;");
        } elseif (self::DC_SORT_TYPE == 'DUE_DESC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains` INNER JOIN `pricing` ON domains.id = pricing.server_id ORDER BY `next_dd` DESC;");
        } elseif (self::DC_SORT_TYPE == 'DUE_ASC') {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains` INNER JOIN `pricing` ON domains.id = pricing.server_id ORDER BY `next_dd`;");
        } else {
            $select = $this->dbConnect()->prepare("SELECT `id` FROM `domains`;");
        }
        $select->execute();
        $count = $select->rowCount();
        if ($count > 0) {
            $this->HTMLPhrase('h4', 'card-section-header', 'Domains <span class="object-count">' . $count . '</span>');
        }
        $this->tagOpen('div', 'row');
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $this->domainCard($row['id']);
        }
        $this->tagClose('div');
    }

    protected function vpsCard(string $id)
    {
        $select = $this->dbConnect()->prepare("
           SELECT servers.id,servers.hostname,servers.`cpu`,servers.cpu_freq,servers.ram,servers.ram_type,servers.`disk`,
           servers.disk_type,servers.os,servers.virt,servers.was_special,locations.name as location,providers.name as provider,pricing.price,pricing.currency,pricing.term,pricing.next_dd
           FROM servers INNER JOIN locations on servers.location = locations.id INNER JOIN providers on servers.provider = providers.id
           INNER JOIN pricing on servers.id = pricing.server_id WHERE servers.id = ? LIMIT 1;");
        $select->execute([$id]);
        $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
        ($data['was_special'] == 1) ? $special = ' special-card' : $special = '';
        (is_null($data['next_dd'])) ? $dd_class = 'no-dd' : $dd_class = 'dd-text';
        $this->colOpen('col-12 col-sm-6 col-md-4 col-xl-3');
        $this->tagOpen("div", "card obj-card$special");
        $this->tagOpen('div', 'card-header');
        $this->rowColOpen('row text-center', 'col-12 col-xl-10');
        $this->HTMLphrase('h4', 'hostname-header', $data['hostname']);
        $this->tagClose('div');
        $this->colOpen('col-12 col-xl-2 os-col');
        $this->outputString($this->osIntToIcon($data['os']));
        $this->tagClose('div', 3);
        $this->tagOpen('div', 'card-body');
        $this->HTMLphrase('h6', 'price', '$' . $data['price'] . ' ' . $data['currency'] . ' ' . $this->paymentTerm($data['term']));
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('h6', 'provider', $data['provider']);
        $this->tagClose('div', 2);
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('h6', 'location', $data['location']);
        $this->tagClose('div', 2);
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('p', $dd_class, "Due in {$this->processDueDate($data['id'], $data['term'], $data['next_dd'])} days");
        $this->tagClose('div', 2);
        $this->rowColOpen('row cpu-row', 'col-6');
        $this->outputString('<i class="fas fa-microchip"></i>');
        $this->HTMLphrase('p', 'value', '' . $data['cpu'] . '<span class="data-type">@</span>' . $this->mhzToGhz($data['cpu_freq']) . '<span class="data-type">Ghz</span>');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->outputString('<i class="fas fa-box"></i>');
        $this->HTMLphrase('p', 'value', '<span class="data-type">' . $data['virt'] . '</span>');
        $this->tagClose('div', 2);
        $this->rowColOpen('row mem-disk-row', 'col-6');
        $this->outputString('<i class="fas fa-memory"></i>');
        $this->HTMLphrase('p', 'value', '' . $data['ram'] . '<span class="data-type">' . $data['ram_type'] . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->outputString('<i class="fas fa-hdd"></i>');
        $this->HTMLphrase('p', 'value', '' . $data['disk'] . '<span class="data-type">' . $data['disk_type'] . '</span>');
        $this->tagClose('div', 2);
        $this->rowColOpen('row text-center', 'col-6');
        $this->outputString('<a class="btn btn-main" id="viewMoreServer" value="' . $id . '" data-target="#viewMoreServerModal" data-toggle="modal" href="#" role="button">More</a>');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->outputString('<a class="btn btn-second" id="editServer" value="' . $id . '" data-target="#editServerModal" data-toggle="modal" href="#" role="button">Edit</a>');
        $this->tagClose('div', 5);
    }

    protected function SharedHostingCard(string $id)
    {
        $select = $this->dbConnect()->prepare("
           SELECT shared_hosting.id,shared_hosting.domain,shared_hosting.disk_as_gb,shared_hosting.type,shared_hosting.was_special,locations.name as location,providers.name as provider,pricing.price,pricing.currency,pricing.term,pricing.next_dd
           FROM shared_hosting INNER JOIN locations on shared_hosting.location = locations.id INNER JOIN providers on shared_hosting.provider = providers.id
           INNER JOIN pricing on shared_hosting.id = pricing.server_id WHERE shared_hosting.id = ? LIMIT 1;");
        $select->execute([$id]);
        $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
        ($data['was_special'] == 1) ? $special = ' special-card' : $special = '';
        (is_null($data['next_dd'])) ? $dd_class = 'no-dd' : $dd_class = 'dd-text';
        $this->colOpen('col-12 col-sm-6 col-md-4 col-xl-3');
        $this->tagOpen("div", "card obj-card$special");
        $this->tagOpen('div', 'card-header');
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('h4', 'hostname-header', $data['domain']);;
        $this->tagClose('div', 3);
        $this->tagOpen('div', 'card-body');
        $this->HTMLphrase('h6', 'price', '$' . $data['price'] . ' ' . $data['currency'] . ' ' . $this->paymentTerm($data['term']));
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('h6', 'provider', $data['provider']);
        $this->tagClose('div', 2);
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('h6', 'location', $data['location']);
        $this->tagClose('div', 2);
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('p', $dd_class, "Due in {$this->processDueDate($data['id'], $data['term'], $data['next_dd'])} days");
        $this->tagClose('div', 2);
        $this->rowColOpen('row mem-disk-row', 'col-6');
        $this->outputString('<i class="fas fa-box"></i>');
        $this->HTMLphrase('p', 'value', '<span class="data-type">' . $data['type'] . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->outputString('<i class="fas fa-hdd"></i>');
        $this->HTMLphrase('p', 'value', '<span class="data-type">' . $data['disk_as_gb'] . '<span class="data-type">GB</span>');
        $this->tagClose('div', 2);
        $this->rowColOpen('row text-center', 'col-6');
        $this->outputString('<a class="btn btn-main" id="viewMoreSharedHosting" value="' . $id . '" data-target="#viewMoreModalSharedHosting" data-toggle="modal" href="#" role="button">More</a>');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->outputString('<a class="btn btn-second" id="editSharedHosting" value="' . $id . '" data-target="#editModalSharedHosting" data-toggle="modal" href="#" role="button">Edit</a>');
        $this->tagClose('div', 5);
    }

    protected function domainCard(string $id)
    {
        $select = $this->dbConnect()->prepare("
           SELECT domains.id,domains.domain,domains.attached_to,providers.name as provider, pricing.price,pricing.currency,pricing.term,pricing.next_dd
           FROM domains INNER JOIN providers on domains.provider = providers.id
           INNER JOIN pricing on domains.id = pricing.server_id WHERE domains.id = ? LIMIT 1;");
        $select->execute([$id]);
        $data = $select->fetchAll(PDO::FETCH_ASSOC)[0];
        (is_null($data['next_dd'])) ? $dd_class = 'no-dd' : $dd_class = 'dd-text';
        $this->colOpen('col-12 col-sm-6 col-md-4 col-xl-3');
        $this->tagOpen("div", "card obj-card");
        $this->tagOpen('div', 'card-header');
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('h4', 'hostname-header', $data['domain']);
        $this->tagClose('div', 3);
        $this->tagOpen('div', 'card-body');
        $this->HTMLphrase('h6', 'price', '$' . $data['price'] . ' ' . $data['currency'] . ' ' . $this->paymentTerm($data['term']));
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('h6', 'provider', $data['provider']);
        $this->tagClose('div', 2);
        $this->rowColOpen('row text-center', 'col-12');
        $this->HTMLphrase('p', $dd_class, "Due in {$this->processDueDate($data['id'], $data['term'], $data['next_dd'])} days");
        $this->tagClose('div', 2);
        $this->rowColOpen('row text-center', 'col-6');
        $this->outputString('<a class="btn btn-main" id="viewMoreDomain" value="' . $id . '" data-target="#viewMoreModalDomain" data-toggle="modal" href="#" role="button">More</a>');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->outputString('<a class="btn btn-second" id="editDomain" value="' . $id . '" data-target="#editModalDomain" data-toggle="modal" href="#" role="button">Edit</a>');
        $this->tagClose('div', 5);
    }

    public function editServerModal()
    {
        $this->outputString('<div class="modal fade" id="editServerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">');
        $this->outputString('<div class="modal-dialog" role="document">');
        $this->tagOpen('div', 'modal-content');
        $this->tagOpen('div', 'modal-header');
        $this->outputString('<h4 class="modal-title w-100" id="me_hostname_header"></h4>');
        $this->outputString('<button type="button" class="close" data-dismiss="modal" aria-label="Close">');
        $this->outputString('<span aria-hidden="true">&times;</span>');
        $this->tagClose('button');
        $this->tagClose('div');
        $this->tagOpen('div', 'modal-body');
        $this->outputString('<form id="editForm" method="post">');

        $this->rowColOpen('form-row', 'col-8');
        $this->outputString('<label for="me_delete">Delete server data</label>');
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->outputString('<label class="switch"><input type="checkbox" name="me_delete" id="me_delete"><span class="slider round"></span></label>');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-8');
        $this->outputString('<label for="me_non_active">No longer have (Keep info)</label>');
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->outputString('<label class="switch"><input type="checkbox" name="me_non_active" id="me_non_active"><span class="slider round"></span></label>');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Hostname');
        $this->textInput('me_hostname', '', 'form-control', true);
        $this->tagClose('div');
        $this->hiddenInput('me_server_id');
        $this->hiddenInput('action', 'update');
        $this->hiddenInput('type', 'server_modal_edit');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('NS1');
        $this->textInput('me_ns1', '', 'form-control', false);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('NS2');
        $this->textInput('me_ns2', '', 'form-control', false);
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Price');
        $this->numberInput('me_price', '', 'form-control', true, 0, 999, 'any');
        $this->tagClose('div');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Term');
        $this->selectElement('me_term');
        $this->termSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Currency');
        $this->selectElement('me_currency');
        $this->CurrencySelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 2);
        $this->colOpen('col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('OS');
        $this->selectElement('me_os');
        $this->OsSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Virt');
        $this->selectElement('me_virt');
        $this->virtSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('SSH Port');
        $this->textInput('me_ssh_port');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('IPv4');
        $this->textInput('me_ipv4');
        $this->tagClose('div', 3);
        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('IPv6');
        $this->textInput('me_ipv6');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Owned since');
        $this->outputString('<input type="date" class="form-control" id="me_owned_since" name="me_owned_since">');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Next due date');
        $this->outputString('<input type="date" class="form-control" id="me_next_dd" name="me_next_dd">');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('CPU amount');
        $this->numberInput('me_cpu_amount', '', 'form-control', false, 1, 48);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Bandwidth');
        $this->numberInput('me_bandwidth', '', 'form-control', false, 1, 9999);
        $this->outputString('<div class="input-group-append"><span class="input-group-text">TB</span></div>');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Total disk');
        $this->numberInput('me_disk', '', 'form-control', false, 0.5, 9999, 'any');
        $this->outputString('<div class="input-group-append"><span class="input-group-text">GB</span></div>');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Ram');
        $this->numberInput('me_ram', '', 'form-control', false, 0.5, 9999, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Type');
        $this->selectElement('me_ram_type');
        $this->selectOption('MB', 'MB', true);
        $this->selectOption('GB', 'GB');
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Swap');
        $this->numberInput('me_swap', '', 'form-control', false, 0.5, 9999, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Type');
        $this->selectElement('me_swap_type');
        $this->selectOption('MB', 'MB', true);
        $this->selectOption('GB', 'GB');
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->htmlPhrase('p', 'm-desc', 'Notes:');
        $this->outputString("<textarea class='form-control' id='me_notes' name='me_notes' rows='4' cols='40' maxlength='255'>");
        $this->outputString("</textarea>");
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-12');
        $this->htmlPhrase('p', 'm-desc', 'Update YABs disk & network speeds:');
        $this->outputString("<textarea class='form-control' id='me_yabs' name='me_yabs' rows='4' cols='40' placeholder='First line must be: # ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #'>");
        $this->outputString("</textarea>");
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Tags');
        $this->tagsInput('me_tags', 'form-control');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row text-center', 'col-12');
        $this->submitInput('Update', 'submitInput', 'btn btn-second');
        $this->tagClose('div', 2);
        $this->tagClose('form');
        $this->tagClose('div', 4);
    }

    public function editSharedHostingModal()
    {
        $this->outputString('<div class="modal fade" id="editModalSharedHosting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">');
        $this->outputString('<div class="modal-dialog" role="document">');
        $this->tagOpen('div', 'modal-content');
        $this->tagOpen('div', 'modal-header');
        $this->outputString('<h4 class="modal-title w-100" id="sh_me_hostname_header"></h4>');
        $this->outputString('<button type="button" class="close" data-dismiss="modal" aria-label="Close">');
        $this->outputString('<span aria-hidden="true">&times;</span>');
        $this->tagClose('button');
        $this->tagClose('div');
        $this->tagOpen('div', 'modal-body');
        $this->outputString('<form id="editSharedHostingForm" method="post">');

        $this->rowColOpen('form-row', 'col-8');
        $this->outputString('<label for="sh_me_delete">Delete shared hosting data</label>');
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->outputString('<label class="switch"><input type="checkbox" name="sh_me_delete" id="sh_me_delete"><span class="slider round"></span></label>');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-8');
        $this->outputString('<label for="sh_me_non_active">No longer have (Keep info)</label>');
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->outputString('<label class="switch"><input type="checkbox" name="sh_me_non_active" id="sh_me_non_active"><span class="slider round"></span></label>');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Hostname');
        $this->textInput('sh_me_hostname', '', 'form-control', true);
        $this->tagClose('div');
        $this->hiddenInput('sh_me_server_id');
        $this->hiddenInput('action', 'update');
        $this->hiddenInput('type', 'shared_hosting_modal_edit');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Price');
        $this->numberInput('sh_me_price', '', 'form-control', true, 0, 999, 'any');
        $this->tagClose('div');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Term');
        $this->selectElement('sh_me_term');
        $this->termSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Currency');
        $this->selectElement('sh_me_currency');
        $this->CurrencySelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Owned since');
        $this->outputString('<input type="date" class="form-control" id="sh_me_owned_since" name="sh_me_owned_since">');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Next due date');
        $this->outputString('<input type="date" class="form-control" id="sh_me_next_dd" name="sh_me_next_dd">');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Bandwidth');
        $this->numberInput('sh_me_bandwidth', '', 'form-control', false, 1, 99999);
        $this->outputString('<div class="input-group-append"><span class="input-group-text">GB</span></div>');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Total disk');
        $this->numberInput('sh_me_storage', '', 'form-control', false, 0.5, 9999, 'any');
        $this->outputString('<div class="input-group-append"><span class="input-group-text">GB</span></div>');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Domains');
        $this->numberInput('sh_me_domains_count', '', 'form-control', false, 1, 99999, '1');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Emails');
        $this->numberInput('sh_me_emails', '', 'form-control', false, 1, 99999, '1');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Databases');
        $this->numberInput('sh_me_db', '', 'form-control', false, 1, 99999, '1');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('FTP');
        $this->numberInput('sh_me_ftp', '', 'form-control', false, 1, 99999, '1');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row text-center', 'col-12');
        $this->submitInput('Update', 'submitInput', 'btn btn-second');
        $this->tagClose('div', 2);
        $this->tagClose('form');
        $this->tagClose('div', 4);
    }

    public function editDomainModal()
    {
        $this->outputString('<div class="modal fade" id="editModalDomain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">');
        $this->outputString('<div class="modal-dialog" role="document">');
        $this->tagOpen('div', 'modal-content');
        $this->tagOpen('div', 'modal-header');
        $this->outputString('<h4 class="modal-title w-100" id="d_me_hostname_header"></h4>');
        $this->outputString('<button type="button" class="close" data-dismiss="modal" aria-label="Close">');
        $this->outputString('<span aria-hidden="true">&times;</span>');
        $this->tagClose('button');
        $this->tagClose('div');
        $this->tagOpen('div', 'modal-body');
        $this->outputString('<form id="editDomainForm" method="post">');

        $this->rowColOpen('form-row', 'col-8');
        $this->outputString('<label for="d_me_delete">Delete domain data</label>');
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->outputString('<label class="switch"><input type="checkbox" name="d_me_delete" id="d_me_delete"><span class="slider round"></span></label>');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-8');
        $this->outputString('<label for="d_me_non_active">No longer have (Keep info)</label>');
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->outputString('<label class="switch"><input type="checkbox" name="d_me_non_active" id="d_me_non_active"><span class="slider round"></span></label>');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Domain');
        $this->textInput('d_me_hostname', '', 'form-control', true);
        $this->tagClose('div');
        $this->hiddenInput('d_me_server_id');
        $this->hiddenInput('action', 'update');
        $this->hiddenInput('type', 'domain_modal_edit');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Price');
        $this->numberInput('d_me_price', '', 'form-control', true, 0, 999, 'any');
        $this->tagClose('div');
        $this->tagClose('div');
        $this->colOpen('col-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Term');
        $this->selectElement('d_me_term');
        $this->domainTermSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Currency');
        $this->selectElement('d_me_currency');
        $this->CurrencySelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Owned since');
        $this->outputString('<input type="date" class="form-control" id="d_me_owned_since" name="d_me_owned_since">');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Next due date');
        $this->outputString('<input type="date" class="form-control" id="d_me_next_dd" name="d_me_next_dd">');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('NS1');
        $this->textInput('d_me_ns1', '', 'form-control', false, 1, 124);
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('NS2');
        $this->textInput('d_me_ns2', '', 'form-control', false, 1, 124);
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row text-center', 'col-12');
        $this->submitInput('Update', 'submitInput', 'btn btn-second');
        $this->tagClose('div', 2);
        $this->tagClose('form');
        $this->tagClose('div', 4);
    }

    protected function addVPSFormYabs()
    {
        $this->rowColOpen('row', 'col-12');
        $this->tagOpen('div', 'card');
        $this->tagOpen('div', 'card-header');
        $this->HTMLphrase('h2', 'text-center', 'Add server from YABs');
        $this->tagClose('div');
        $this->tagOpen('div', 'card-body');
        $this->outputString('<form id="yabsForm" method="post">');
        $this->hiddenInput('from_yabs', 'true');
        $this->hiddenInput('has_yabs', '1');

        $this->forumInputsBasic();

        $this->rowColOpen('form-row', 'col-12');
        $this->tagOpen('div', 'form-group');
        $this->outputString('<textarea id="yabs" name="yabs" class="form-control" placeholder="First line must be: # ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #" rows="10" required></textarea>');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 text-center');
        $this->submitInput('Add', 'submitInput', 'btn btn-second');
        $this->tagClose('div', 2);
        $this->tagClose('form');
        $this->tagClose('div', 4);
    }

    protected function addDomainForm()
    {
        $this->rowColOpen('row', 'col-12');
        $this->tagOpen('div', 'card');
        $this->tagOpen('div', 'card-header');
        $this->HTMLphrase('h2', 'text-center', 'Add domain');
        $this->tagClose('div');
        $this->tagOpen('div', 'card-body');
        $this->outputString('<form id="domainForm" method="post">');

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->hiddenInput('domain_form', 'true');
        $this->hiddenInput('has_yabs', '0');
        $this->hiddenInput('action', 'insert');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Domain');
        $this->textInput('domain', '', 'form-control', true, 3, 124);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Registrar');
        $this->textInput('domain_provider', '', 'form-control provider-input', true, 3, 124);
        $this->tagClose('div', 3);

        $this->formPricingRow('domain_');

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Owned since');
        $this->outputString('<input type="date" class="form-control" id="domain_owned_since" name="domain_owned_since">');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Next due date');
        $this->outputString('<input type="date" class="form-control next-dd" id="domain_next_due_date" name="domain_next_due_date">');
        $this->tagClose('div', 3);


        $this->rowColOpen('form-row', 'col-12 text-center');
        $this->submitInput('Add', 'submitInput', 'btn btn-second');
        $this->tagClose('div', 2);
        $this->tagClose('form');
        $this->tagClose('div', 4);
    }

    protected function addSharedHostingForm()
    {
        $this->rowColOpen('row', 'col-12');
        $this->tagOpen('div', 'card');
        $this->tagOpen('div', 'card-header');
        $this->HTMLphrase('h2', 'text-center', 'Add shared hosting');
        $this->tagClose('div');
        $this->tagOpen('div', 'card-body');
        $this->outputString('<form id="sharesHostingForm" method="post">');

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->hiddenInput('shared_hosting_form', 'true');
        $this->hiddenInput('has_yabs', '0');
        $this->hiddenInput('action', 'insert');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Domain');
        $this->textInput('shared_domain', '', 'form-control', true, 3, 124);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Provider');
        $this->textInput('shared_provider', '', 'form-control provider-input', true, 3, 124);
        $this->tagClose('div', 3);

        $this->formPricingRow('shared_');

        $this->rowColOpen('form-row', 'col-12 col-md-2');
        $this->outputString('<label for="shared_was_offer">Was special offer</label>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-2');
        $this->outputString('<label class="switch"><input type="checkbox" name="shared_was_offer" id="shared_was_offer"><span class="slider round"></span></label>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Owned since');
        $this->outputString('<input type="date" class="form-control" id="shared_owned_since" name="shared_owned_since">');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Next due date');
        $this->outputString('<input type="date" class="form-control next-dd" id="shared_next_due_date" name="shared_next_due_date">');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Domains');
        $this->numberInput('shared_domains_amount', '1', 'form-control', true, 1, 9999, '1');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Storage');
        $this->numberInput('shared_storage', '10', 'form-control', true, 1, 9999, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Type');
        $this->selectElement('shared_storage_type');
        $this->selectOption('GB', 'GB', true);
        $this->selectOption('TB', 'TB');
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Databases');
        $this->numberInput('shared_db_amount', '10', 'form-control', true, 1, 9999, '1');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Email');
        $this->numberInput('shared_emails', '25', 'form-control', true, 1, 9999, '1');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('FTP');
        $this->numberInput('shared_ftp', '25', 'form-control', true, 1, 9999, '1');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Bandwidth');
        $this->numberInput('shared_bandwidth', '1', 'form-control', false, 1, 9999, '1');
        $this->outputString('<div class="input-group-append"><span class="input-group-text">TB</span></div>');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Location');
        $this->textInput('shared_location', '', 'form-control location-input', true, 3, 124);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Type');
        $this->selectElement('shared_type');
        $this->sharedHostingTypeOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 text-center');
        $this->submitInput('Add', 'submitInput', 'btn btn-second');
        $this->tagClose('div', 2);
        $this->tagClose('form');
        $this->tagClose('div', 4);
    }

    protected function addVPSForm()
    {
        $this->rowColOpen('row', 'col-12');
        $this->tagOpen('div', 'card');
        $this->tagOpen('div', 'card-header');
        $this->HTMLphrase('h2', 'text-center', 'Add server');
        $this->tagClose('div');
        $this->tagOpen('div', 'card-body');
        $this->outputString('<form id="manualForm" method="post">');
        $this->hiddenInput('manual', 'true');
        $this->hiddenInput('has_yabs', '0');

        $this->forumInputsBasic();

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('CPU amount');
        $this->numberInput('cpu_amount', '1', 'form-control', true, 1, 64, '1');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('CPU speed');
        $this->numberInput('cpu_speed', '3799', 'form-control', false, '1', '5999.999', 'any');
        $this->outputString('<div class="input-group-append"><span class="input-group-text">Mhz</span></div>');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-8');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Total disk');
        $this->numberInput('disk', '10', 'form-control', true, 1, 9999, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Type');
        $this->selectElement('disk_type');
        $this->selectOption('GB', 'GB', true);
        $this->selectOption('TB', 'TB');
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-6 col-md-3');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Ram');
        $this->numberInput('ram', '512', 'form-control', true, 1, 62000, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-3');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Type');
        $this->selectElement('ram_type');
        $this->selectOption('MB', 'MB', true);
        $this->selectOption('GB', 'GB');
        $this->tagClose('select');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-3');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Swap');
        $this->numberInput('swap', '100', 'form-control', true, 1, 62000, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-3');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Type');
        $this->selectElement('swap_type');
        $this->selectOption('MB', 'MB', true);
        $this->selectOption('GB', 'GB');
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 text-center');
        $this->submitInput('Add', 'submitInput', 'btn btn-second');
        $this->tagClose('div', 2);
        $this->tagClose('form');
        $this->tagClose('div', 4);
    }

    protected function formPricingRow(string $id_append = '')
    {
        $this->rowColOpen('form-row', 'col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Price');
        $this->numberInput('' . $id_append . 'price', '8.99', 'form-control', true, 0, 999, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Currency');
        $this->selectElement('' . $id_append . 'currency');
        $this->CurrencySelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Term');
        $this->selectElement('' . $id_append . 'term');
        $this->termSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);
    }

    protected function forumInputsBasic()
    {
        $this->rowColOpen('form-row', 'col-12 col-md-4');
        $this->hiddenInput('action', 'insert');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Hostname');
        $this->textInput('hostname', '', 'form-control', true, 1, 124);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('NS1');
        $this->textInput('ns1', '', 'form-control', false, 1, 124);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('NS2');
        $this->textInput('ns2', '', 'form-control', false, 1, 124);
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-md-3');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Provider');
        $this->textInput('provider', '', 'form-control provider-input', true, 3, 124);
        $this->tagClose('div', 2);
        $this->colOpen('col-md-3');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Price');
        $this->numberInput('price', '', 'form-control', true, 0, 999, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-md-3');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Term');
        $this->selectElement('term');
        $this->termSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 2);
        $this->colOpen('col-md-3');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Currency');
        $this->selectElement('currency');
        $this->CurrencySelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('IPv4');
        $this->textInput('ipv4', '', 'form-control', true, 4, 124);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('IPv6');
        $this->textInput('ipv6', '', 'form-control', false, 4, 124);
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-4');
        $this->outputString('<label for="was_offer">Was special offer</label>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-2');
        $this->outputString('<label class="switch"><input type="checkbox" name="was_offer" id="was_offer"><span class="slider round"></span></label>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->outputString('<label for="dedi_cpu">Dedicated CPU</label>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-2');
        $this->outputString('<label class="switch"><input type="checkbox" name="dedi_cpu" id="dedi_cpu"><span class="slider round"></span></label>');
        $this->tagClose('div', 2);

        $this->rowColOpen('form-row', 'col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('SSH');
        $this->numberInput('ssh_port', '22', 'form-control', true, 1, 999999, 1);
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Virt');
        $this->selectElement('virt');
        $this->virtSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-4');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('OS');
        $this->selectElement('os');
        $this->OsSelectOptions();
        $this->tagClose('select');
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Bandwidth');
        $this->numberInput('bandwidth', '', 'form-control', false, 1, 99999, 'any');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Location');
        $this->textInput('location', '', 'form-control location-input', false, 1, 124);
        $this->tagClose('div', 3);

        $this->rowColOpen('form-row', 'col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Owned since');
        $this->outputString('<input type="date" class="form-control" id="owned_since" name="owned_since">');
        $this->tagClose('div', 2);
        $this->colOpen('col-12 col-md-6');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Next due date');
        $this->outputString('<input type="date" class="form-control next-dd" id="next_due_date" name="next_due_date">');
        $this->tagClose('div', 3);
    }

    protected function pageClose(bool $close_container = true)
    {
        if ($close_container) {
            $this->tagClose('div');
        }
        $this->outputString('<script src="assets/js/jquery.min.js"></script>');
        $this->outputString('<script src="assets/js/bootstrap.min.js"></script>');
        $this->outputString('<script src="assets/js/scripts.min.js"></script>');
        $this->outputString('<link rel="stylesheet" href="assets/css/all.min.css"/>');
        $this->tagClose('body');
        $this->tagClose('html');
    }

    public function mainPage()
    {
        $this->pageHead();
        $this->pageContents();
        $this->pageFooter();
        $this->pageClose();
    }

    protected function searchDiv()
    {
        $this->rowColOpen('row', 'col-12');
        $this->tagOpen('form');
        $this->textInput('searchInput', '', 'form-control', false);
        $this->tagClose('form');
        $this->tagClose('div', 2);
        $this->tagOpen('div', '', 'searchDivBody');
        $this->tagClose('div');
    }

    public function searchResults(string $search_term)
    {
        if (!empty($search_term)) {
            $select = $this->dbConnect()->prepare("SELECT `id`, `hostname`,`ipv4`, `virt`, p.price, p.currency, p.term  FROM `servers` INNER JOIN pricing p on servers.id = p.server_id WHERE `hostname` LIKE ? OR `ipv4` LIKE ? LIMIT 30;");
            $select->execute(["%$search_term%", "%$search_term%"]);
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->rowColOpen('row search-result', 'col-6');
                $this->outputString("<p class='m-value'>{$row['hostname']} <code>{$row['ipv4']}</code> <span class='data-type'>{$row['virt']}</span> {$row['price']} {$row['currency']} <span class='data-type'>" . $this->paymentTerm($row['term']) . "</span></p>");
                $this->tagClose('div');
                $this->colOpen('col-3');
                $this->outputString('<a class="btn btn-main" id="viewMoreServer" value="' . $row['id'] . '" data-target="#viewMoreServerModal" data-toggle="modal" href="#" role="button">View</a>');
                $this->tagClose('div');
                $this->colOpen('col-3');
                $this->outputString('<a class="btn btn-second" id="editServer" value="' . $row['id'] . '" data-target="#editServerModal" data-toggle="modal" href="#" role="button">Edit</a>');
                $this->tagClose('div', 2);
            }
            $select = $this->dbConnect()->prepare("SELECT `id`, `domain`, p.price, p.currency, p.term  FROM `domains` INNER JOIN pricing p on domains.id = p.server_id WHERE `domain` LIKE ? LIMIT 30;");
            $select->execute(["%$search_term%"]);
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->rowColOpen('row search-result', 'col-6');
                $this->outputString("<p class='m-value'>{$row['domain']} <span class='data-type'>domain</span> {$row['price']} {$row['currency']} <span class='data-type'>" . $this->paymentTerm($row['term']) . "</span></p>");
                $this->tagClose('div');
                $this->colOpen('col-6');
                $this->outputString('<a class="btn btn-main" id="viewMoreDomain" value="' . $row['id'] . '" data-target="#viewMoreModalDomain" data-toggle="modal" href="#" role="button">View</a>');
                $this->tagClose('div', 2);
            }
            $select = $this->dbConnect()->prepare("SELECT `id`, `domain`, `type`, p.price, p.currency, p.term  FROM `shared_hosting` INNER JOIN pricing p on shared_hosting.id = p.server_id WHERE `domain` LIKE ? OR `type` LIKE ? LIMIT 30;");
            $select->execute(["%$search_term%", "%$search_term%"]);
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->rowColOpen('row search-result', 'col-6');
                $this->outputString("<p class='m-value'>{$row['domain']} <span class='data-type'>{$row['type']}</span> {$row['price']} {$row['currency']} <span class='data-type'>" . $this->paymentTerm($row['term']) . "</span></p>");
                $this->tagClose('div');
                $this->colOpen('col-6');
                $this->outputString('<a class="btn btn-main" id="viewMoreSharedHosting" value="' . $row['id'] . '" data-target="#viewMoreModalSharedHosting" data-toggle="modal" href="#" role="button">View</a>');
                $this->tagClose('div', 2);
            }
        }
    }

    protected function handleLocation(string $provider)
    {//Inserts location + returns id OR returns id if location already exists
        $select = $this->dbConnect()->prepare("SELECT `id`, `name` FROM `locations` WHERE `name` = ? LIMIT 1;");
        $select->execute([$provider]);
        $row = $select->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {//Yes
            return $row['id'];
        } else {//NO
            $insert = $this->dbConnect()->prepare('INSERT INTO `locations` (`name`) VALUES (?);');
            $insert->execute([$provider]);
            return $this->dbConnect()->lastInsertId();
        }
    }

    protected function handleProvider(string $provider)
    {//Inserts provider + returns id OR returns id if provider already exists
        $select = $this->dbConnect()->prepare("SELECT `id`, `name` FROM `providers` WHERE `name` = ? LIMIT 1;");
        $select->execute([$provider]);
        $row = $select->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {//Yes
            return $row['id'];
        } else {//NO
            $insert = $this->dbConnect()->prepare('INSERT INTO `providers` (`name`) VALUES (?);');
            $insert->execute([$provider]);
            return $this->dbConnect()->lastInsertId();
        }
    }

    public function locationsAutoCompleteGET(string $value)
    {//Returns array from a LIKE query for input term
        $select = $this->dbConnect()->prepare("SELECT `name` FROM locations WHERE `name` LIKE ? LIMIT 16;");
        $select->execute(array('' . $value . '%'));
        $array = array();
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $array[] = $row['name'];
        }
        echo json_encode($array);
    }

    public function providersAutoCompleteGET(string $value)
    {//Returns array from a LIKE query for input term
        $select = $this->dbConnect()->prepare("SELECT `name` FROM providers WHERE `name` LIKE ? LIMIT 16;");
        $select->execute(array('' . $value . '%'));
        $array = array();
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $array[] = $row['name'];
        }
        echo json_encode($array);
    }

    protected function pageFooter(string $text = "My Idlers", string $link = "https://github.com/cp6/my-idlers")
    {
        $this->rowColOpen('row footer-row', 'col-12');
        $this->outputString("<a class='footer-text' href='$link'><p>$text</p></a>");
        $this->tagClose('div', 2);
    }

    public function viewMoreModal(string $item_id)
    {
        $data = json_decode($this->serverData($item_id), true);
        if (!isset($data)) {//returned no data
            exit;
        }
        if (is_null($data['ipv6']) || empty($data['ipv6'])) {
            $ipv6 = '-';
        } else {
            $ipv6 = $data['ipv6'];
        }
        ($data['has_yabs'] == 1) ? $has_yabs = true : $has_yabs = false;
        ($data['has_st'] == 1) ? $has_st = true : $has_st = false;
        $this->tagOpen('div', 'modal-header');
        $this->HTMLphrase('h4', 'modal-title w-100', $data['hostname'], 'view_more_header');
        $this->outputString('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        $this->tagClose('div');
        $this->tagOpen('div', 'modal-body');
        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'IPv4');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->outputString('<code><p class="m-value">' . $data['ipv4'] . '</p></code>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'IPv6');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->outputString('<code><p class="m-value">' . $ipv6 . '</p></code>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'NS1');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->outputString('<code><p class="m-value">' . $data['ns1'] . '</p></code>');
        $this->tagClose('div', 2);
        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'NS2');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->outputString('<code><p class="m-value">' . $data['ns2'] . '</p></code>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'SSH Port');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '<code>' . $data['ssh_port'] . '</code>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Bandwidth');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $data['bandwidth'] . '<span class="data-type">' . $data['bandwidth_type'] . '</span>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Disk');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $data['disk'] . '<span class="data-type">' . $data['disk_type'] . '</span>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Location');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['location']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Provider');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['provider']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'OS');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $this->osIntToString($data['os']));
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Due in');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $this->processDueDate($data['server_id'], $data['term'], $data['next_dd']) . '<span class="data-type">days</span>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-section-row', 'col-12 text-center');
        $this->HTMLphrase('p', 'm-section-text', 'CPU');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Amount');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['cpu']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Frequency');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['cpu_freq']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-12');
        $this->outputString('<i><p class="m-value">' . $data['cpu_type'] . '</p></i>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-section-row', 'col-12 text-center');
        $this->outputString('<p class="m-section-text">Ram</p>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Ram');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $data['ram'] . '<span class="data-type">' . $data['ram_type'] . '</span>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Swap');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $data['swap'] . '<span class="data-type">' . $data['swap_type'] . '</span>');
        $this->tagClose('div', 2);

        if ($has_yabs) {
            $this->rowColOpen('row m-section-row', 'col-12 text-center');
            $this->HTMLphrase('p', 'm-section-text', 'GeekBench 5');
            $this->tagClose('div', 2);
            $this->rowColOpen('row m-row', 'col-4');
            $this->HTMLphrase('p', 'm-desc', 'single: ');
            $this->HTMLphrase('p', 'm-value', $data['gb5_single']);
            $this->tagClose('div');
            $this->colOpen('col-4');
            $this->HTMLphrase('p', 'm-desc', 'multi: ');
            $this->HTMLphrase('p', 'm-value', $data['gb5_multi']);
            $this->tagClose('div');
            $this->colOpen('col-4');
            $this->HTMLphrase('p', 'm-desc', 'id: ');
            $this->outputString('<a id="m_gb5_id_link" href="https://browser.geekbench.com/v5/cpu/' . $data['gb5_id'] . '"><p class="m-value">' . $data['gb5_id'] . '</p></a>');
            $this->tagClose('div', 2);

            $this->rowColOpen('row m-section-row', 'col-12 text-center');
            $this->HTMLphrase('p', 'm-section-text', 'Disk test');
            $this->tagClose('div', 2);

            $this->rowColOpen('row m-row', 'col-6');
            $this->HTMLphrase('p', 'm-desc', '4k: ');
            $this->HTMLphrase('p', 'm-value', '' . $data['4k'] . '<span class="data-type">' . $data['4k_type'] . '</span>');
            $this->tagClose('div');
            $this->colOpen('col-6');
            $this->HTMLphrase('p', 'm-desc', '64k: ');
            $this->HTMLphrase('p', 'm-value', '' . $data['64k'] . '<span class="data-type">' . $data['64k_type'] . '</span>');
            $this->tagClose('div', 2);

            $this->rowColOpen('row m-row', 'col-6');
            $this->HTMLphrase('p', 'm-desc', '512k: ');
            $this->HTMLphrase('p', 'm-value', '' . $data['512k'] . '<span class="data-type">' . $data['512k_type'] . '</span>');
            $this->tagClose('div');
            $this->colOpen('col-6');
            $this->HTMLphrase('p', 'm-desc', '1m: ');
            $this->HTMLphrase('p', 'm-value', '' . $data['1m'] . '<span class="data-type">' . $data['1m_type'] . '</span>');
            $this->tagClose('div', 2);
        }
        $this->rowColOpen('row m-section-row', 'col-12 text-center');
        $this->HTMLphrase('p', 'm-section-text', 'Pricing');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-12');
        $this->HTMLphrase('p', 'm-value', '' . $data['price'] . ' <span class="data-type">' . $data['currency'] . '</span> ');
        $this->HTMLphrase('p', 'm-value', $this->paymentTerm($data['term']));
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-section-row', 'col-12 text-center');
        $this->HTMLphrase('p', 'm-section-text', 'Other');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Owned since');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['owned_since']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Dedicated: ');
        $this->tagClose('div');
        $this->colOpen('col-2');
        $this->HTMLphrase('p', 'm-value', $this->intToYesNo($data['is_dedicated']));
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->HTMLphrase('p', 'm-desc', 'Dedi CPU: ');
        $this->tagClose('div');
        $this->colOpen('col-2');
        $this->HTMLphrase('p', 'm-value', $this->intToYesNo($data['is_cpu_dedicated']));
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Is offer: ');
        $this->tagClose('div');
        $this->colOpen('col-2');
        $this->HTMLphrase('p', 'm-value', $this->intToYesNo($data['was_special']));
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->HTMLphrase('p', 'm-desc', 'AES-NI: ');
        $this->tagClose('div');
        $this->colOpen('col-2');
        $this->HTMLphrase('p', 'm-value', $this->intToYesNo($data['aes_ni']));
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'VM-x/AMD-V: ');
        $this->tagClose('div');
        $this->colOpen('col-2');
        $this->HTMLphrase('p', 'm-value', $this->intToYesNo($data['amd_v']));
        $this->tagClose('div');
        $this->colOpen('col-4');
        $this->HTMLphrase('p', 'm-desc', 'Virt: ');
        $this->tagClose('div');
        $this->colOpen('col-2');
        $this->HTMLphrase('p', 'm-value', $data['virt']);
        $this->tagClose('div', 2);
        if ($has_yabs && $has_st) {
            $this->rowColOpen('row m-section-row', 'col-12 text-center');
            $this->HTMLphrase('p', 'm-section-text', 'Network test');
            $this->tagClose('div', 2);
            $this->tagOpen('div', 'row');
            $this->outputString('<div class="col-6"><p class="m-desc">Location:</p></div>');
            $this->outputString('<div class="col-3"><p class="m-desc">Send:</p></div>');
            $this->outputString('<div class="col-3"><p class="m-desc">Receive:</p></div>');
            $this->tagClose('div');
            for ($i = 0; $i <= 7; $i++) {
                if (isset($data[$i])) {
                    $this->rowColOpen('row', 'col-6');
                    $this->HTMLphrase('p', 'm-value', $data[$i]['location']);
                    $this->tagClose('div');
                    $this->colOpen('col-3');
                    $this->HTMLphrase('p', 'm-value', '' . $data[$i]['send'] . '<span class="data-type">' . $data[$i]['send_type'] . '</span>');
                    $this->tagClose('div');
                    $this->colOpen('col-3');
                    $this->HTMLphrase('p', 'm-value', '' . $data[$i]['recieve'] . '<span class="data-type">' . $data[$i]['recieve_type'] . '</span>');
                    $this->tagClose('div');
                    $this->tagClose('div');
                }
            }
        }

        $this->rowColOpen('row m-section-row', 'col-12 text-center');
        $this->htmlPhrase('p', 'm-section-text', 'Notes');
        $this->outputString("<textarea class='form-control' id='server_notes' name='server_notes' rows='4' cols='40' maxlength='255' disabled>");
        if (is_null($data['notes']) || empty($data['notes'])) {
            $this->outputString('');
        } else {
            $this->outputString($data['notes']);
        }
        $this->outputString("</textarea>");
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-section-row', 'col-12 text-center');
        $this->HTMLphrase('p', 'm-section-text', 'Tags');
        $this->tagClose('div', 2);
        $this->rowColOpen('row m-row', 'col-12');
        $this->tagOpen('ul');
        $tags_arr = explode(",", $data['tags']);
        foreach ($tags_arr as $tag) {
            if (!empty($tag)) {
                $this->HTMLphrase('li', 'tags-list', $tag);
            }
        }
        $this->tagClose('ul');
        $this->tagClose('div', 3);
        if (file_exists("yabs/{$data['server_id']}.txt")) {
            $this->rowColOpen('row text-center', 'col-12 col-md-6');
            $this->outputString('<a class="btn btn-main view-yabs-btn" id="viewYabs" value="' . $item_id . '" data-target="#yabsModal" data-toggle="modal" href="#" role="button">View YABs</a>');
            $this->tagClose('div');
            $this->colOpen('col-12 col-md-6');
            $this->outputString('<a class="btn btn-third" id="closeViewMoreModal" role="button" data-dismiss="modal">Close</a>');
            $this->tagClose('div', 2);
        } else {
            $this->rowColOpen('row text-center', 'col-12');
            $this->outputString('<a class="btn btn-third" id="closeViewMoreModal" role="button" data-dismiss="modal">Close</a>');
            $this->tagClose('div', 2);
        }
    }

    public function viewMoreSharedHostingModal(string $item_id)
    {
        $data = json_decode($this->sharedHostingData($item_id), true);
        if (!isset($data)) {//returned no data
            exit;
        }
        $this->tagOpen('div', 'modal-header');
        $this->HTMLphrase('h4', 'modal-title w-100', $data['domain'], 'view_more_header');
        $this->outputString('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        $this->tagClose('div');
        $this->tagOpen('div', 'modal-body');

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Type');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['type']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Provider');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['provider']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Location');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['location']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Cost');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $data['price'] . ' <span class="data-type">' . $data['currency'] . ' ' . $this->paymentTerm($data['term']) . '</span> ');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Due in');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $this->processDueDate($item_id, $data['term'], $data['next_dd']) . '<span class="data-type">days</span>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Owned since');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['owned_since']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-section-row', 'col-12 text-center');
        $this->HTMLphrase('p', 'm-section-text', 'About');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Storage');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $data['disk'] . '<span class="data-type">' . $data['disk_type'] . '</span>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Domains');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['domains_limit']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Email accounts');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['emails']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'FTP accounts');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['ftp']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Databases');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['db']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Bandwidth');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $data['bandwidth'] . '<span class="data-type">TB</span>');
        $this->tagClose('div', 2);
    }

    public function viewMoreDomainModal(string $item_id)
    {
        $data = json_decode($this->domainData($item_id), true);
        if (!isset($data)) {//returned no data
            exit;
        }
        $this->tagOpen('div', 'modal-header');
        $this->HTMLphrase('h4', 'modal-title w-100', $data['domain'], 'view_more_header');
        $this->outputString('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        $this->tagClose('div');
        $this->tagOpen('div', 'modal-body');
        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'NS2');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->outputString('<code><p class="m-value">' . $data['ns1'] . '</p></code>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'NS2');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->outputString('<code><p class="m-value">' . $data['ns2'] . '</p></code>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Provider');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['provider']);
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Cost');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $data['price'] . ' <span class="data-type">' . $data['currency'] . ' ' . $this->paymentTerm($data['term']) . '</span> ');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Due in');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', '' . $this->processDueDate($item_id, $data['term'], $data['next_dd']) . '<span class="data-type">days</span>');
        $this->tagClose('div', 2);

        $this->rowColOpen('row m-row', 'col-4');
        $this->HTMLphrase('p', 'm-desc', 'Owned since');
        $this->tagClose('div');
        $this->colOpen('col-8');
        $this->HTMLphrase('p', 'm-value', $data['owned_since']);
        $this->tagClose('div', 2);
    }

    protected function orderForm()
    {
        $this->outputString('<form id="orderForm" method="post">');
        $this->rowColOpen('form-row', 'col-9');
        $this->hiddenInput('order_form', 'true');
        $this->tagOpen('div', 'input-group');
        $this->inputPrepend('Order by');
        $this->selectElement('order_by', 'form-control');
        $this->selectOption('CPU count DESC', '1', true);
        $this->selectOption('CPU count ASC', '2');
        $this->selectOption('CPU Frequency DESC', '3');
        $this->selectOption('CPU Frequency ASC', '4');
        $this->selectOption('Ram amount DESC', '5');
        $this->selectOption('Ram amount ASC', '6');
        $this->selectOption('Disk Amount DESC', '7');
        $this->selectOption('Disk Amount ASC', '8');
        $this->selectOption('Owned since DESC', '9');
        $this->selectOption('Owned since ASC', '10');
        $this->selectOption('GB5 single DESC', '11');
        $this->selectOption('GB5 single ASC', '12');
        $this->selectOption('GB5 multi DESC', '13');
        $this->selectOption('GB5 multi ASC', '14');
        $this->selectOption('Price DESC', '15');
        $this->selectOption('Price ASC', '16');
        $this->selectOption('Price p/m DESC', '17');
        $this->selectOption('Price p/m ASC', '18');
        $this->selectOption('4k speed DESC', '19');
        $this->selectOption('4k speed ASC', '20');
        $this->selectOption('64k speed DESC', '21');
        $this->selectOption('64k speed ASC', '22');
        $this->selectOption('512k speed DESC', '23');
        $this->selectOption('512k speed ASC', '24');
        $this->selectOption('1m speed DESC', '25');
        $this->selectOption('1m speed ASC', '26');
        $this->selectOption('Network send DESC', '27');
        $this->selectOption('Network send ASC', '28');
        $this->selectOption('Network receive DESC', '29');
        $this->selectOption('Network receive ASC', '30');
        $this->selectOption('Bandwidth amount DESC', '31');
        $this->selectOption('Bandwidth amount ASC', '32');
        $this->tagClose('select');
        $this->tagClose('div', 2);
        $this->colOpen('col-3');
        $this->submitInput('Order', 'submitInput', 'btn btn-second btn-block order-btn');
        $this->tagClose('div', 2);
        $this->tagClose('form');
        $this->outputString('<div id="orderDiv"></div>');
    }

    public function orderTable(int $order_type)
    {
        if (in_array($order_type, array(1, 2, 3, 4, 5, 6, 7, 8))) {
            $this->tableHeader(array('Hostname', 'CPU', 'Freq', 'Ram', 'Swap', 'Disk'));
            $base_query = "SELECT `id`, `hostname`, `cpu`, `cpu_freq`, `ram_mb`, `swap_mb`, `disk_gb` FROM `servers`";
            if ($order_type == 1) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `cpu` DESC;");
            } elseif ($order_type == 2) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `cpu`;");
            } elseif ($order_type == 3) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `cpu_freq` DESC;");
            } elseif ($order_type == 4) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `cpu_freq`;");
            } elseif ($order_type == 5) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `ram_mb` DESC;");
            } elseif ($order_type == 6) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `ram_mb`;");
            } elseif ($order_type == 7) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `disk_gb` DESC;");
            } elseif ($order_type == 8) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `disk_gb`;");
            }
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->tagOpen('tr');
                $this->outputString("<td>{$row['hostname']}</td>");
                $this->outputString("<td>{$row['cpu']}</td>");
                $this->outputString("<td>{$row['cpu_freq']}</td>");
                $this->outputString("<td>" . number_format($row['ram_mb'], 2) . "<span class='table-val-type'>MB</span></td>");
                $this->outputString("<td>" . number_format($row['swap_mb'], 0) . "<span class='table-val-type'>MB</span></td>");
                $this->outputString("<td>" . number_format($row['disk_gb'], 0) . "<span class='table-val-type'>GB</span></td>");
                $this->tagClose('tr');
            }
        } elseif (in_array($order_type, array(9, 10))) {
            $this->tableHeader(array('Hostname', 'Owned since', 'CPU', 'Freq', 'Ram', 'Disk'));
            $base_query = "SELECT `id`, `hostname`, `cpu`, `cpu_freq`, `ram_mb`, `disk_gb`, DATE_FORMAT(`owned_since`, '%D %b %Y') as dt FROM `servers`";
            if ($order_type == 9) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `owned_since` DESC;");
            } elseif ($order_type == 10) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `owned_since`;");
            }
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->tagOpen('tr');
                $this->outputString("<td>{$row['hostname']}</td>");
                $this->outputString("<td>{$row['dt']}</td>");
                $this->outputString("<td>{$row['cpu']}</td>");
                $this->outputString("<td>{$row['cpu_freq']}</td>");
                $this->outputString("<td>" . number_format($row['ram_mb'], 2) . "<span class='table-val-type'>MB</span></td>");
                $this->outputString("<td>" . number_format($row['disk_gb'], 0) . "<span class='table-val-type'>GB</span></td>");
                $this->tagClose('tr');
            }
        } elseif (in_array($order_type, array(11, 12, 13, 14))) {
            $this->tableHeader(array('Hostname', 'GB5 single', 'GB5 multi', 'CPU', 'Freq', 'Ram', 'Disk'));
            $base_query = "SELECT `id`, `hostname`, `cpu`, `cpu_freq`, `ram_mb`, `disk_gb`, `gb5_single`, `gb5_multi` FROM `servers` WHERE has_yabs = 1";
            if ($order_type == 11) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `gb5_single` DESC;");
            } elseif ($order_type == 12) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `gb5_single`;");
            } elseif ($order_type == 13) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `gb5_multi` DESC;");
            } elseif ($order_type == 14) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `gb5_multi`;");
            }
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->tagOpen('tr');
                $this->outputString("<td>{$row['hostname']}</td>");
                $this->outputString("<td>{$row['gb5_single']}</td>");
                $this->outputString("<td>{$row['gb5_multi']}</td>");
                $this->outputString("<td>{$row['cpu']}</td>");
                $this->outputString("<td>{$row['cpu_freq']}</td>");
                $this->outputString("<td>" . number_format($row['ram_mb'], 2) . "<span class='table-val-type'>MB</span></td>");
                $this->outputString("<td>" . number_format($row['disk_gb'], 0) . "<span class='table-val-type'>GB</span></td>");
                $this->tagClose('tr');
            }
        } elseif (in_array($order_type, array(15, 16, 17, 18))) {
            $this->tableHeader(array('Hostname', 'Price', 'Term', 'P/M', 'CPU', 'Ram', 'Disk'));
            $base_query = "SELECT `id`, `hostname`, `cpu`, `ram_mb`, `disk_gb`, `price`, `currency`, `term`, `per_month` FROM `servers` INNER JOIN `pricing`p on servers.id = p.server_id";
            if ($order_type == 15) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `as_usd` DESC;");
            } elseif ($order_type == 16) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `as_usd`;");
            } elseif ($order_type == 17) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `per_month` DESC;");
            } elseif ($order_type == 18) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `per_month`;");
            }
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->tagOpen('tr');
                $this->outputString("<td>{$row['hostname']}</td>");
                $this->outputString("<td>{$row['price']} {$row['currency']}</td>");
                $this->outputString("<td>" . $this->paymentTerm($row['term']) . "</td>");
                $this->outputString("<td>{$row['per_month']}</td>");
                $this->outputString("<td>{$row['cpu']}</td>");
                $this->outputString("<td>" . number_format($row['ram_mb'], 2) . "<span class='table-val-type'>MB</span></td>");
                $this->outputString("<td>" . number_format($row['disk_gb'], 0) . "<span class='table-val-type'>GB</span></td>");
                $this->tagClose('tr');
            }
        } elseif (in_array($order_type, array(19, 20, 21, 22, 23, 24, 25, 26))) {
            $this->tableHeader(array('Hostname', '4k', '64k', '512k', '1m', 'CPU', 'Ram', 'Disk'));
            $base_query = "SELECT `id`, `hostname`, `cpu`, `ram_mb`, `disk_gb`, `4k`, `4k_type`, `64k`, `64k_type`, `512k`, `512k_type`, `1m`, `1m_type` FROM `servers` INNER JOIN `disk_speed`p on servers.id = p.server_id WHERE has_yabs = 1";
            if ($order_type == 19) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `4k_as_mbps` DESC;");
            } elseif ($order_type == 20) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `4k_as_mbps`;");
            } elseif ($order_type == 21) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `64k_as_mbps` DESC;");
            } elseif ($order_type == 22) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `64k_as_mbps`;");
            } elseif ($order_type == 23) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `512k_as_mbps` DESC;");
            } elseif ($order_type == 24) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `512k_as_mbps`;");
            } elseif ($order_type == 25) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `1m_as_mbps` DESC;");
            } elseif ($order_type == 26) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `1m_as_mbps`;");
            }
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->tagOpen('tr');
                $this->outputString("<td>{$row['hostname']}</td>");
                $this->outputString("<td>{$row['4k']}<span class='table-val-type'>{$row['4k_type']}</span></td>");
                $this->outputString("<td>{$row['64k']}<span class='table-val-type'>{$row['64k_type']}</span></td>");
                $this->outputString("<td>{$row['512k']}<span class='table-val-type'>{$row['512k_type']}</span></td>");
                $this->outputString("<td>{$row['1m']}<span class='table-val-type'>{$row['1m_type']}</span></td>");
                $this->outputString("<td>{$row['cpu']}</td>");
                $this->outputString("<td>" . number_format($row['ram_mb'], 2) . "<span class='table-val-type'>MB</span></td>");
                $this->outputString("<td>" . number_format($row['disk_gb'], 0) . "<span class='table-val-type'>GB</span></td>");
                $this->tagClose('tr');
            }
        } elseif (in_array($order_type, array(27, 28, 29, 30))) {
            $this->tableHeader(array('Hostname', 'Send', 'Receive', 'Location', 'CPU', 'Ram', 'Disk'));
            $base_query = "SELECT servers.id, `hostname`, `cpu`, `ram_mb`, `disk_gb`, `send`, `send_type`, p.location, `recieve`, `recieve_type` FROM `servers` INNER JOIN `speed_tests`p on servers.id = p.server_id WHERE has_yabs = 1";
            if ($order_type == 27) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `send_as_mbps` DESC LIMIT 80;");
            } elseif ($order_type == 28) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `send_as_mbps` LIMIT 80;");
            } elseif ($order_type == 29) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `recieve_as_mbps` DESC LIMIT 80;");
            } elseif ($order_type == 30) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `recieve_as_mbps` LIMIT 80;");
            }
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->tagOpen('tr');
                $this->outputString("<td>{$row['hostname']}</td>");
                $this->outputString("<td>{$row['send']}<span class='table-val-type'>{$row['send_type']}</span></td>");
                $this->outputString("<td>{$row['recieve']}<span class='table-val-type'>{$row['recieve_type']}</span></td>");
                $this->outputString("<td>{$row['location']}</td>");
                $this->outputString("<td>{$row['cpu']}</td>");
                $this->outputString("<td>" . number_format($row['ram_mb'], 2) . "<span class='table-val-type'>MB</span></td>");
                $this->outputString("<td>" . number_format($row['disk_gb'], 0) . "<span class='table-val-type'>GB</span></td>");
                $this->tagClose('tr');
            }
        } elseif (in_array($order_type, array(31, 32))) {
            $this->tableHeader(array('Hostname', 'Bandwidth', 'CPU', 'Freq', 'Ram', 'Disk'));
            $base_query = "SELECT `id`, `hostname`, `cpu`, `cpu_freq`, `ram_mb`, `disk_gb`, `bandwidth` FROM `servers`";
            if ($order_type == 31) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `bandwidth` DESC;");
            } elseif ($order_type == 32) {
                $select = $this->dbConnect()->prepare("$base_query ORDER BY `bandwidth`;");
            }
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $this->tagOpen('tr');
                $this->outputString("<td>{$row['hostname']}</td>");
                $this->outputString("<td>{$row['bandwidth']}</td>");
                $this->outputString("<td>{$row['cpu']}</td>");
                $this->outputString("<td>{$row['cpu_freq']}</td>");
                $this->outputString("<td>" . number_format($row['ram_mb'], 2) . "<span class='table-val-type'>MB</span></td>");
                $this->outputString("<td>" . number_format($row['disk_gb'], 0) . "<span class='table-val-type'>GB</span></td>");
                $this->tagClose('tr');
            }
        }
        $this->outputString('</tbody></table></div>');
    }

    public function infoCard()
    {
        $select = $this->dbConnect()->prepare("SELECT COUNT(*), SUM(`cpu`), SUM(`disk_gb`), SUM(`ram_mb`), SUM(`swap_mb`), SUM(`bandwidth`), SUM(`was_special`), SUM(`gb5_single`), SUM(`gb5_multi`)  FROM `servers`;");
        $select->execute();
        $row = $select->fetchAll(PDO::FETCH_ASSOC)[0];
        $inactive_servers = $this->dbConnect()->prepare("SELECT COUNT(*) as inactive FROM `servers` WHERE `still_have` = 0;");
        $inactive_servers->execute();
        $inactive_servers_count = $inactive_servers->fetch()['inactive'];
        $kvm = $this->dbConnect()->prepare("SELECT COUNT(*) as kvm_count FROM `servers` WHERE `virt` = 'KVM';");
        $kvm->execute();
        $kvm_count = $kvm->fetch()['kvm_count'];
        $ovz = $this->dbConnect()->prepare("SELECT COUNT(*) as ovz_count FROM `servers` WHERE `virt` = 'OVZ';");
        $ovz->execute();
        $ovz_count = $ovz->fetch()['ovz_count'];
        $dedi = $this->dbConnect()->prepare("SELECT COUNT(*) as dedi_count FROM `servers` WHERE `virt` = 'DEDI';");
        $dedi->execute();
        $dedi_count = $dedi->fetch()['dedi_count'];
        $lxc = $this->dbConnect()->prepare("SELECT COUNT(*) as lxc_count FROM `servers` WHERE `virt` = 'LXC';");
        $lxc->execute();

        $lxc_count = $lxc->fetch()['lxc_count'];
        $domains = $this->dbConnect()->prepare("SELECT COUNT(*) as domains_count FROM `domains` WHERE `still_have` = 1;");
        $domains->execute();
        $domains_count = $domains->fetch()['domains_count'];

        $domains_inactive = $this->dbConnect()->prepare("SELECT COUNT(*) as domains_count FROM `domains` WHERE `still_have` = 0;");
        $domains_inactive->execute();
        $domains_inactive_count = $domains_inactive->fetch()['domains_count'];

        $sh = $this->dbConnect()->prepare("SELECT COUNT(*) as sh_count FROM `shared_hosting` WHERE `still_have` = 1;");
        $sh->execute();
        $sh_count = $sh->fetch()['sh_count'];
        $sh_inactive = $this->dbConnect()->prepare("SELECT COUNT(*) as sh_count FROM `shared_hosting` WHERE `still_have` = 0;");
        $sh_inactive->execute();
        $sh_inactive_count = $sh_inactive->fetch()['sh_count'];

        $cpu_freq = $this->dbConnect()->prepare("SELECT `cpu_freq` FROM `servers` ORDER BY `cpu_freq` DESC LIMIT 1;");
        $cpu_freq->execute();
        $fastest_cpu_freq = $cpu_freq->fetch()['cpu_freq'];

        $single_high = $this->dbConnect()->prepare("SELECT `gb5_single` FROM `servers` ORDER BY `gb5_single` DESC LIMIT 1;");
        $single_high->execute();
        $highest_single_gb5 = $single_high->fetch()['gb5_single'];

        $multi_high = $this->dbConnect()->prepare("SELECT `gb5_multi` FROM `servers` ORDER BY `gb5_multi` DESC LIMIT 1;");
        $multi_high->execute();
        $highest_multi_gb5 = $multi_high->fetch()['gb5_multi'];

        $oldest = $this->dbConnect()->prepare("SELECT `hostname`, `owned_since`  FROM `servers` ORDER BY `owned_since`;");
        $oldest->execute();
        $oldest_row = $oldest->fetchAll(PDO::FETCH_ASSOC)[0];

        $oldest_d = $this->dbConnect()->prepare("SELECT `domain`, `owned_since`  FROM `domains` ORDER BY `owned_since`;");
        $oldest_d->execute();
        $oldest_d_row = $oldest_d->fetchAll(PDO::FETCH_ASSOC)[0];

        $sel_price = $this->dbConnect()->prepare("SELECT `as_usd`, `term`, `usd_per_month` FROM `pricing`;");
        $sel_price->execute();
        $tally = 0;
        $pm_tally = 0;
        while ($row1 = $sel_price->fetch(PDO::FETCH_ASSOC)) {
            $cost = $row1['as_usd'];
            $term = $row1['term'];
            $pm = $row1['usd_per_month'];
            $pm_tally = ($pm_tally + $pm);
            if ($term == 1) {
                $tally = $tally + ($cost * 12);
            } elseif ($term == 2) {
                $tally = $tally + ($cost * 4);
            } elseif ($term == 3) {
                $tally = $tally + ($cost * 2);
            } elseif ($term == 4) {
                $tally = $tally + $cost;
            } elseif ($term == 4) {
                $tally = $tally + ($cost / 2);
            } elseif ($term == 4) {
                $tally = $tally + ($cost / 3);
            }
        }
        $this->outputString("<div class='card' id='infoCard'>");
        $this->tagOpen('div', 'card-header text-center');
        $this->HTMLphrase('h2', '', 'My idlers info');
        $this->tagClose('div');
        $this->tagOpen('div', 'card-body');
        $this->rowColOpen('row info-row', 'col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total servers: <span class="info-val">' . $row['COUNT(*)'] . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total shared hosting: <span class="info-val">' . $sh_count . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total domains: <span class="info-val">' . $domains_count . '</span>');
        $this->tagClose('div', 2);


        $this->rowColOpen('row info-row', 'col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'KVM/OVZ/DEDI/LXC: <span class="info-val">' . $kvm_count . '/' . $ovz_count . '/' . $dedi_count . '/' . $lxc_count . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'No longer have servers: <span class="info-val">' . $inactive_servers_count . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'No longer have domains/shared: <span class="info-val">' . $domains_inactive_count . '/' . $sh_inactive_count . '</span>');
        $this->tagClose('div', 2);


        $this->rowColOpen('row info-row', 'col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total CPU: <span class="info-val">' . $row['SUM(`cpu`)'] . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Fastest CPU: <span class="info-val">' . $fastest_cpu_freq . '<span class="data-type">Mhz</span></span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total disk: <span class="info-val">' . number_format($row['SUM(`disk_gb`)'], 0) . '<span class="data-type">GB</span></span>');
        $this->tagClose('div', 2);
        $this->rowColOpen('row info-row', 'col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total bandwidth: <span class="info-val">' . number_format($row['SUM(`bandwidth`)'], 0) . '<span class="data-type">TB</span></span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total ram: <span class="info-val">' . number_format($row['SUM(`ram_mb`)'], 2) . '<span class="data-type">MB</span></span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total swap: <span class="info-val">' . number_format($row['SUM(`swap_mb`)'], 2) . '<span class="data-type">MB</span></span>');
        $this->tagClose('div', 2);
        $this->rowColOpen('row info-row', 'col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total gb5_single: <span class="info-val">' . number_format($row['SUM(`gb5_single`)'], 0) . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total gb5_multi: <span class="info-val">' . number_format($row['SUM(`gb5_multi`)'], 0) . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Highest single/multi: <span class="info-val">' . $highest_single_gb5 . '/' . $highest_multi_gb5 . '</span>');
        $this->tagClose('div', 2);
        $this->rowColOpen('row info-row', 'col-12 col-md-4');;
        $this->HTMLphrase('p', 'info-desc', 'Special priced: <span class="info-val">' . $row['SUM(`was_special`)'] . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Oldest server: <span class="info-val">' . $oldest_row['hostname'] . ' ' . $oldest_row['owned_since'] . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Oldest domain: <span class="info-val">' . $oldest_d_row['domain'] . ' ' . $oldest_d_row['owned_since'] . '</span>');
        $this->tagClose('div', 2);
        $this->rowColOpen('row info-row', 'col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total cost p/m USD: <span class="info-val">$' . $pm_tally . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');
        $this->HTMLphrase('p', 'info-desc', 'Total cost per year USD: <span class="info-val">$' . $tally . '</span>');
        $this->tagClose('div');
        $this->colOpen('col-12 col-md-4');

        $this->tagClose('div', 4);
    }

    protected function hasPassedDate(string $the_date)
    {
        if (new DateTime() > new DateTime($the_date)) {
            //current date time has passed $the_date
            return true;
        } else {
            //current date time has NOT passed $the_date
            return false;
        }
    }

    protected function nextDueDate(int $term, string $last_dd)
    {
        $date = new DateTime($last_dd);
        if ($term == 1) {
            $date->add(new DateInterval('P1M'));
        } elseif ($term == 2) {
            $date->add(new DateInterval('P3M'));
        } elseif ($term == 3) {
            $date->add(new DateInterval('P6M'));
        } elseif ($term == 4) {
            $date->add(new DateInterval('P1Y'));
        } elseif ($term == 5) {
            $date->add(new DateInterval('P2Y'));
        } elseif ($term == 6) {
            $date->add(new DateInterval('P3Y'));
        }
        return $date->format('Y-m-d');
    }

    protected function processDueDate(string $item_id, int $term, $last_dd)
    {//Will return days until due. Will update if passed due date and then return days until due
        if (is_null($last_dd)) {
            return "-";//Due date not set
        } else {
            if ($this->hasPassedDate($last_dd)) {
                $update = $this->dbConnect()->prepare("UPDATE `pricing` SET `next_dd` = ? WHERE `server_id` = ? LIMIT 1;");
                $new_dd = $this->nextDueDate($term, $last_dd);
                $update->execute([$new_dd, $item_id]);
                return $this->daysAway($new_dd);
            } else {
                return $this->daysAway($last_dd);
            }
        }
    }

    public function showYabsModal(string $item_id)
    {
        $this->tagOpen('form');
        $this->outputString('<textarea class="form-control" id="yabsTextBox" name="yabsTextBox" rows="40" cols="50">');
        $this->outputString(file_get_contents("yabs/$item_id.txt"));
        $this->tagClose('textarea');
        $this->tagClose('form');
        $this->rowColOpen('row text-center', 'col-12');
        $this->outputString('<a class="btn btn-third" role="button" data-dismiss="modal">Close YABs</a>');
        $this->tagClose('div',2);
    }

}

class itemInsert extends idlers
{
    public string $item_id;
    public array $data;

    public function __construct(array $data)
    {
        $this->item_id = $this->genId();
        $this->data = $data;
    }

    public function insertBasicWithYabs()
    {//Insert data from form EXCEPT the YABs output
        $data = $this->data;
        $item_id = $this->item_id;
        (isset($data['dedi_cpu'])) ? $dedi_cpu = 1 : $dedi_cpu = 0;
        ($data['virt'] == 'DEDI') ? $dedi = 1 : $dedi = 0;
        (isset($data['was_offer'])) ? $offer = 1 : $offer = 0;
        (empty($data['ipv6'])) ? $ipv6 = null : $ipv6 = $data['ipv6'];
        $location_id = $this->handleLocation($data['location']);
        $provider_id = $this->handleProvider($data['provider']);
        $insert = $this->dbConnect()->prepare('INSERT IGNORE INTO `servers` (id, hostname, location, provider, ipv4,ipv6, owned_since, os, is_cpu_dedicated, is_dedicated, was_special, bandwidth, virt, has_yabs, ns1, ns2, ssh_port) VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?)');
        $insert->execute([$item_id, $data['hostname'], $location_id, $provider_id, $data['ipv4'], $ipv6, $data['owned_since'], $data['os'], $dedi_cpu, $dedi, $offer, $data['bandwidth'], $data['virt'], $data['has_yabs'], $data['ns1'], $data['ns2'], $data['ssh_port']]);
        $this->insertPrice($data['price'], $data['currency'], $data['term'], $data['next_due_date']);
        return $item_id;
    }

    public function insertBasic()
    {//Manual form insert (NO YABs)
        $data = $this->data;
        $item_id = $this->item_id;
        (isset($data['dedi_cpu'])) ? $dedi_cpu = 1 : $dedi_cpu = 0;
        ($data['virt'] == 'DEDI') ? $dedi = 1 : $dedi = 0;
        (isset($data['was_offer'])) ? $offer = 1 : $offer = 0;
        (empty($data['ipv6'])) ? $ipv6 = null : $ipv6 = $data['ipv6'];
        ($data['ram_type'] == 'GB') ? $ram_mb = $this->GBtoMB($data['ram']) : $ram_mb = $data['ram'];
        ($data['swap_type'] == 'GB') ? $swap_mb = $this->GBtoMB($data['swap']) : $swap_mb = $data['swap'];
        ($data['disk_type'] == 'TB') ? $disk_gb = $this->TBtoGB($data['disk']) : $disk_gb = $data['disk'];
        $location_id = $this->handleLocation($data['location']);
        $provider_id = $this->handleProvider($data['provider']);
        $insert = $this->dbConnect()->prepare('INSERT IGNORE INTO `servers` (id, hostname, location, provider, ipv4,ipv6, owned_since, os, is_cpu_dedicated, is_dedicated, was_special, bandwidth, virt, cpu, cpu_freq, ram, ram_type, swap, swap_type, disk, disk_type, ram_mb, swap_mb, disk_gb, ns1, ns2, ssh_port) VALUES (?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $insert->execute([$item_id, $data['hostname'], $location_id, $provider_id, $data['ipv4'], $ipv6, $data['owned_since'], $data['os'], $dedi_cpu, $dedi, $offer, $data['bandwidth'], $data['virt'], $data['cpu_amount'], $data['cpu_speed'], $data['ram'], $data['ram_type'], $data['swap'], $data['swap_type'], $data['disk'], $data['disk_type'], $ram_mb, $swap_mb, $disk_gb, $data['ns1'], $data['ns2'], $data['ssh_port']]);
        $this->insertPrice($data['price'], $data['currency'], $data['term'], $data['next_due_date']);
        return $item_id;
    }

    public function insertSharedHosting()
    {//domains form insert
        $data = $this->data;
        $item_id = $this->item_id;
        ($data['shared_storage_type'] == 'TB') ? $disk_gb = $this->TBtoGB($data['shared_storage']) : $disk_gb = $data['shared_storage'];
        (isset($data['shared_was_offer'])) ? $offer = 1 : $offer = 0;
        $location_id = $this->handleLocation($data['shared_location']);
        $provider_id = $this->handleProvider($data['shared_provider']);
        $insert = $this->dbConnect()->prepare('INSERT IGNORE INTO `shared_hosting` (id, domain, domains_limit, emails, disk, disk_type, disk_as_gb, ftp, db, bandwidth, provider, location, was_special, still_have, type, owned_since) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $insert->execute([$item_id, $data['shared_domain'], $data['shared_domains_amount'], $data['shared_emails'], $data['shared_storage'], $data['shared_storage_type'], $disk_gb, $data['shared_ftp'], $data['shared_db_amount'], $data['shared_bandwidth'], $provider_id, $location_id, $offer, '1', $data['shared_type'], $data['shared_owned_since']]);
        $this->insertPrice($data['shared_price'], $data['shared_currency'], $data['shared_term'], $data['shared_next_due_date']);
        return $item_id;
    }

    public function insertDomain()
    {//domains form insert
        $data = $this->data;
        $domain_id = $this->item_id;
        $provider_id = $this->handleProvider($data['domain_provider']);
        $insert = $this->dbConnect()->prepare('INSERT IGNORE INTO `domains` (id, domain, provider, owned_since) VALUES (?,?,?,?)');
        $insert->execute([$domain_id, $data['domain'], $provider_id, $data['domain_owned_since']]);
        $this->insertPrice($data['domain_price'], $data['domain_currency'], $data['domain_term'], $data['domain_next_due_date']);
        return $domain_id;
    }

    public function insertYabsData(bool $save_yabs = true)
    {//YABS data handler
        $file_name = 'yabsFromForm.txt';
        $logfile = fopen($file_name, "w") or die("Unable to open file!");
        fwrite($logfile, $this->data['yabs']);
        if ($save_yabs) {
            $this->saveYABS($this->data['yabs'], "{$this->item_id}.txt");
        }
        fclose($logfile);
        $file = @fopen($file_name, 'r');
        if ($file) {
            $array = explode("\n", fread($file, filesize($file_name)));
            //echo json_encode($array);
            //exit;
        }
        if (strpos($array[0], '# ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #') !== false || count($array) < 50) {
            $version_array = explode(' ', preg_replace('!\s+!', ' ', $this->trimRemoveR($array[2])));
            $version = $version_array[1];//YABs version
            $cpu = $this->trimRemoveR(str_replace(':', '', strstr($array[10], ': ')));
            $cpu_spec = explode(' ', strstr($array[11], ': '));//: 2 @ 3792.872 MHz
            $cpu_cores = $cpu_spec[1];
            $cpu_freq = $cpu_spec[3];
            $ram_line = $this->trimRemoveR(str_replace(':', '', strstr($array[14], ': ')));
            $ram = floatval($ram_line);
            $ram_type = $this->datatype($ram_line);
            $swap_line = $this->trimRemoveR(str_replace(':', '', strstr($array[15], ': ')));
            $swap = floatval($swap_line);
            $swap_type = $this->datatype($swap_line);
            $disk_line = $this->trimRemoveR(str_replace(':', '', strstr($array[16], ': ')));
            $disk = floatval($disk_line);
            $disk_type = $this->datatype($disk_line);
            $io_3 = explode(' ', preg_replace('!\s+!', ' ', $array[24]));
            $io_6 = explode(' ', preg_replace('!\s+!', ' ', $array[30]));
            (strpos($array[12], 'Enabled') !== false) ? $aes_ni = 1 : $aes_ni = 0;
            (strpos($array[13], 'Enabled') !== false) ? $vm_amd_v = 1 : $vm_amd_v = 0;
            $d4k_as_mbps = $this->diskSpeedAsMbps($io_3[3], $this->floatValue($io_3[2]));
            $d64k_as_mbps = $this->diskSpeedAsMbps($io_3[7], $this->floatValue($io_3[6]));
            $d512k_as_mbps = $this->diskSpeedAsMbps($io_6[3], $this->floatValue($io_6[2]));
            $d1m_as_mbps = $this->diskSpeedAsMbps($io_6[7], $this->floatValue($io_6[6]));
            $disk_test_arr = array($this->item_id, $this->floatValue($io_3[2]), $io_3[3], $this->floatValue($io_3[6]), $io_3[7], $this->floatValue($io_6[2]), $io_6[3], $this->floatValue($io_6[6]), $io_6[7], $d4k_as_mbps, $d64k_as_mbps, $d512k_as_mbps, $d1m_as_mbps);
            $this->insertDiskTest($disk_test_arr);
            if ($array[45] == "Geekbench 5 Benchmark Test:\r") {
                //No ipv6
                //Has short ipv4 network speed testing (-r)
                $start_st = 36;
                $end_st = 43;
                $gb_s = 49;
                $gb_m = 50;
                $gb_url = 51;
            } elseif ($array[40] == "Geekbench 5 Benchmark Test:\r") {
                //No ipv6
                //Has full ipv4 network speed testing
                $start_st = 36;
                $end_st = 38;
                $gb_s = 44;
                $gb_m = 45;
                $gb_url = 46;
            } elseif ($array[40] == "iperf3 Network Speed Tests (IPv6):\r") {
                //HAS ipv6
                //Has short ipv4 & ipv6 network speed testing
                $start_st = 36;
                $end_st = 38;
                $gb_s = 52;
                $gb_m = 53;
                $gb_url = 54;
            } elseif ($array[55] == "Geekbench 5 Benchmark Test:\r") {
                //HAS ipv6
                //Has full ipv4 & ipv6 network speed testing
                $start_st = 36;
                $end_st = 43;
                $gb_s = 59;
                $gb_m = 60;
                $gb_url = 61;
            }
            $geekbench_single = $this->intValue($array[$gb_s]);
            $geekbench_multi = $this->intValue($array[$gb_m]);
            $geek_full_url = explode(' ', preg_replace('!\s+!', ' ', $array[$gb_url]));
            $gb5_id = substr($geek_full_url[3], strrpos($geek_full_url[3], '/') + 1);//
            $has_a_speed_test = false;
            for ($i = $start_st; $i <= $end_st; $i++) {
                if (strpos($array[$i], 'busy') !== false) {
                    //Has a "busy" result, No insert
                } else {
                    $data = explode(' ', preg_replace('!\s+!', ' ', $array[$i]));
                    $send_as_mbps = $this->networkSpeedAsMbps($this->yabsSpeedValues($data)['send_type'], $this->yabsSpeedValues($data)['send']);
                    $recieve_as_mbps = $this->networkSpeedAsMbps($this->yabsSpeedValues($data)['receive_type'], $this->yabsSpeedValues($data)['receive']);
                    $insert = $this->dbConnect()->prepare('INSERT INTO `speed_tests` (`server_id`, `location`, `send`, `send_type`,`send_as_mbps`, `recieve`,`recieve_type`, `recieve_as_mbps`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                    $insert->execute([$this->item_id, $this->yabsSpeedLoc($data)['location'], $this->yabsSpeedValues($data)['send'], $this->yabsSpeedValues($data)['send_type'], $send_as_mbps, $this->yabsSpeedValues($data)['receive'], $this->yabsSpeedValues($data)['receive_type'], $recieve_as_mbps]);
                    $has_a_speed_test = true;
                }
            }
            if ($has_a_speed_test) {
                $update_st = $this->dbConnect()->prepare('UPDATE `servers` SET `has_st` = 1 WHERE `id` = ? LIMIT 1;');
                $update_st->execute([$this->item_id]);
            }
            ($ram_type == 'GB') ? $ram_mb = $this->GBtoMB($ram) : $ram_mb = $ram;
            ($swap_type == 'GB') ? $swap_mb = $this->GBtoMB($swap) : $swap_mb = $swap;
            ($disk_type == 'TB') ? $disk_gb = $this->TBtoGB($disk) : $disk_gb = $disk;
            $update = $this->dbConnect()->prepare('UPDATE `servers` SET `cpu` = ?, `cpu_freq` = ?, `cpu_type` = ?, ram = ?, ram_type = ?, swap = ?, swap_type = ?, disk = ?, disk_type = ?, `aes_ni` = ?, `amd_v` = ?, gb5_single = ?, gb5_multi = ?, gb5_id = ?, ram_mb = ?, swap_mb = ?, disk_gb = ? WHERE `id` = ? LIMIT 1;');
            $update->execute([$cpu_cores, $cpu_freq, $cpu, $ram, $ram_type, $swap, $swap_type, $disk, $disk_type, $aes_ni, $vm_amd_v, $geekbench_single, $geekbench_multi, $gb5_id, $ram_mb, $swap_mb, $disk_gb, $this->item_id]);
            return true;
        } else {
            //Not formatted right
            return false;
        }
    }

    protected function insertDiskTest(array $results)
    {//Insert disk io results from the built array
        $insert = $this->dbConnect()->prepare("INSERT IGNORE INTO `disk_speed` (`server_id`, `4k`, `4k_type`, `64k`, `64k_type`, `512k`, `512k_type`, `1m`, `1m_type`, `4k_as_mbps`, `64k_as_mbps`, `512k_as_mbps`, `1m_as_mbps`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);");
        return $insert->execute([$this->item_id, $results[1], $results[2], $results[3], $results[4], $results[5], $results[6], $results[7], $results[8], $results[9], $results[10], $results[11], $results[12]]);
    }

    protected function insertPrice(string $price, string $currency, int $term, string $next_dd)
    {//Insert price data
        $as_usd = $this->convertToUSD($price, $currency);
        $insert = $this->dbConnect()->prepare("INSERT IGNORE INTO `pricing` (server_id, price, currency, term, as_usd, per_month, usd_per_month, next_dd) VALUES (?,?,?,?,?,?,?,?);");
        return $insert->execute([$this->item_id, $price, $currency, $term, $as_usd, $this->costAsPerMonth($price, $term), $this->costAsPerMonth($as_usd, $term), $next_dd]);
    }
}

class itemUpdate extends idlers
{
    public string $item_id;
    public string $type;
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        if (isset($data['sh_me_server_id'])) {
            $this->item_id = $data['sh_me_server_id'];
            $this->type = 'SHARED';
        } elseif (isset($data['d_me_server_id'])) {
            $this->item_id = $data['d_me_server_id'];
            $this->type = 'DOMAIN';
        } else {
            $this->item_id = $data['me_server_id'];
            $this->type = 'SERVER';
        }
    }

    public function updateServerFromModal()
    {
        $data = $this->data;
        if (!isset($data['me_non_active'])) {
            $this->updateActiveStatus(1);
        } elseif ($data['me_non_active'] == 'on') {
            $this->updateActiveStatus(0);
        }
        $update = $this->dbConnect()->prepare("UPDATE `servers` SET `hostname` = ?,`ipv4` = ?,`ipv6` = ?,`cpu` = ?,`bandwidth` = ?,`disk` = ?,`ram` = ?,`ram_type` = ?,`swap` = ?,`swap_type` = ?, `virt` = ?, `tags` = ?, `owned_since` = ?, `ns1` = ?, `ns2` = ?, `ssh_port` = ?, `notes` = ? WHERE `id`= ? LIMIT 1;");
        return $update->execute([$data['me_hostname'], $data['me_ipv4'], $data['me_ipv6'], $data['me_cpu_amount'], $data['me_bandwidth'], $data['me_disk'], $data['me_ram'], $data['me_ram_type'], $data['me_swap'], $data['me_swap_type'], $data['me_virt'], $data['me_tags'], $data['me_owned_since'], $data['me_ns1'], $data['me_ns2'], $data['me_ssh_port'], $data['me_notes'], $this->item_id]);
    }

    public function updateServerPricingFromModal()
    {
        $data = $this->data;
        $as_usd = $this->convertToUSD($data['me_price'], $data['me_currency']);
        $update = $this->dbConnect()->prepare("UPDATE `pricing` SET `price` = ?,`currency` = ?,`term` = ?,`as_usd` = ?,`per_month` = ?, `usd_per_month` = ?, `next_dd` = ? WHERE `server_id`= ? LIMIT 1;");
        return $update->execute([$data['me_price'], $data['me_currency'], $data['me_term'], $as_usd, $this->costAsPerMonth($data['me_price'], $data['me_term']), $this->costAsPerMonth($as_usd, $data['me_term']), $data['me_next_dd'], $this->item_id]);
    }

    public function updateSharedHostingFromModal()
    {
        $data = $this->data;
        if (!isset($data['sh_me_non_active'])) {
            $this->updateActiveStatus(1);
        } elseif ($data['sh_me_non_active'] == 'on') {
            $this->updateActiveStatus(0);
        }
        $update = $this->dbConnect()->prepare("UPDATE `shared_hosting` SET `domain` = ?,`domains_limit` = ?,`emails` = ?,`disk` = ?,`disk_as_gb` = ?,`disk_type` = ?,`ftp` = ?,`db` = ?,`bandwidth` = ?,`owned_since` = ? WHERE `id`= ? LIMIT 1;");
        return $update->execute([$data['sh_me_hostname'], $data['sh_me_domains_count'], $data['sh_me_emails'], $data['sh_me_storage'], $data['sh_me_storage'], 'GB', $data['sh_me_ftp'], $data['sh_me_db'], $data['sh_me_bandwidth'], $data['sh_me_owned_since'], $this->item_id]);
    }

    public function updateSharedHostingPricingFromModal()
    {
        $data = $this->data;
        $as_usd = $this->convertToUSD($data['sh_me_price'], $data['sh_me_currency']);
        $update = $this->dbConnect()->prepare("UPDATE `pricing` SET `price` = ?,`currency` = ?,`term` = ?,`as_usd` = ?,`per_month` = ?, `usd_per_month` = ?, `next_dd` = ? WHERE `server_id`= ? LIMIT 1;");
        return $update->execute([$data['sh_me_price'], $data['sh_me_currency'], $data['sh_me_term'], $as_usd, $this->costAsPerMonth($data['sh_me_price'], $data['sh_me_term']), $this->costAsPerMonth($as_usd, $data['sh_me_term']), $data['sh_me_next_dd'], $this->item_id]);
    }

    public function updateDomainFromModal()
    {
        $data = $this->data;
        if (!isset($data['d_me_non_active'])) {
            $this->updateActiveStatus(1);
        } elseif ($data['d_me_non_active'] == 'on') {
            $this->updateActiveStatus(0);
        }
        $update = $this->dbConnect()->prepare("UPDATE `domains` SET `domain` = ?,`ns1` = ?,`ns2` = ?,`owned_since` = ? WHERE `id`= ? LIMIT 1;");
        return $update->execute([$data['d_me_hostname'], $data['d_me_ns1'], $data['d_me_ns2'], $data['d_me_owned_since'], $this->item_id]);
    }

    public function updateDomainPricingFromModal()
    {
        $data = $this->data;
        $as_usd = $this->convertToUSD($data['d_me_price'], $data['d_me_currency']);
        $update = $this->dbConnect()->prepare("UPDATE `pricing` SET `price` = ?,`currency` = ?,`term` = ?,`as_usd` = ?,`per_month` = ?, `usd_per_month` = ?, `next_dd` = ? WHERE `server_id`= ? LIMIT 1;");
        return $update->execute([$data['d_me_price'], $data['d_me_currency'], $data['d_me_term'], $as_usd, $this->costAsPerMonth($data['d_me_price'], $data['d_me_term']), $this->costAsPerMonth($as_usd, $data['d_me_term']), $data['d_me_next_dd'], $this->item_id]);
    }

    public function deleteObjectData()
    {//Delete server data from all relevant tables
        if ($this->type == 'SHARED') {
            $table = 'shared_hosting';
        } elseif ($this->type == 'DOMAIN') {
            $table = 'domains';
        } else {
            $table = 'servers';
        }
        $item_id = $this->item_id;
        $del_server = $this->dbConnect()->prepare("DELETE FROM `$table` WHERE `id` = ? LIMIT 1;");
        $del_server->execute([$item_id]);
        $del_pricing = $this->dbConnect()->prepare("DELETE FROM `pricing` WHERE `server_id` = ? LIMIT 1;");
        $del_pricing->execute([$item_id]);
        if ($this->type == 'SERVER') {
            $del_disk = $this->dbConnect()->prepare("DELETE FROM `disk_speed` WHERE `server_id` = ?;");
            $del_disk->execute([$item_id]);
            $del_speed = $this->dbConnect()->prepare("DELETE FROM `speed_tests` WHERE `server_id` = ?;");
            $del_speed->execute([$item_id]);
        }
    }

    protected function updateActiveStatus(int $status)
    {
        if ($this->type == 'SHARED') {
            $table = 'shared_hosting';
        } elseif ($this->type == 'DOMAIN') {
            $table = 'domains';
        } else {
            $table = 'servers';
        }
        $update = $this->dbConnect()->prepare("UPDATE `$table` SET `still_have` = ? WHERE `id` = ? LIMIT 1;");
        return $update->execute([$status, $this->item_id]);
    }

    public function updateYabsData(bool $save_yabs = true)
    {//YABS data handler
        $file_name = 'yabsFromForm.txt';
        $logfile = fopen($file_name, "w") or die("Unable to open file!");
        fwrite($logfile, $this->data['me_yabs']);
        if ($save_yabs) {
            $this->saveYABS($this->data['me_yabs'], "{$this->item_id}_" . date('Y-m-d') . ".txt");
        }
        fclose($logfile);
        $file = @fopen($file_name, 'r');
        if ($file) {
            $array = explode("\n", fread($file, filesize($file_name)));
        }
        if (strpos($array[0], '# ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #') !== false || count($array) < 50) {
            $io_3 = explode(' ', preg_replace('!\s+!', ' ', $array[24]));
            $io_6 = explode(' ', preg_replace('!\s+!', ' ', $array[30]));
            (strpos($array[12], 'Enabled') !== false) ? $aes_ni = 1 : $aes_ni = 0;
            (strpos($array[13], 'Enabled') !== false) ? $vm_amd_v = 1 : $vm_amd_v = 0;
            $d4k_as_mbps = $this->diskSpeedAsMbps($io_3[3], $this->floatValue($io_3[2]));
            $d64k_as_mbps = $this->diskSpeedAsMbps($io_3[7], $this->floatValue($io_3[6]));
            $d512k_as_mbps = $this->diskSpeedAsMbps($io_6[3], $this->floatValue($io_6[2]));
            $d1m_as_mbps = $this->diskSpeedAsMbps($io_6[7], $this->floatValue($io_6[6]));
            $disk_test_arr = array($this->item_id, $this->floatValue($io_3[2]), $io_3[3], $this->floatValue($io_3[6]), $io_3[7], $this->floatValue($io_6[2]), $io_6[3], $this->floatValue($io_6[6]), $io_6[7], $d4k_as_mbps, $d64k_as_mbps, $d512k_as_mbps, $d1m_as_mbps);
            $insert = $this->dbConnect()->prepare("INSERT IGNORE INTO `disk_speed` (`server_id`, `4k`, `4k_type`, `64k`, `64k_type`, `512k`, `512k_type`, `1m`, `1m_type`, `4k_as_mbps`, `64k_as_mbps`, `512k_as_mbps`, `1m_as_mbps`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);");
            $insert->execute([$this->item_id, $disk_test_arr[1], $disk_test_arr[2], $disk_test_arr[3], $disk_test_arr[4], $disk_test_arr[5], $disk_test_arr[6], $disk_test_arr[7], $disk_test_arr[8], $disk_test_arr[9], $disk_test_arr[10], $disk_test_arr[11], $disk_test_arr[12]]);
            if ($array[45] == "Geekbench 5 Benchmark Test:\r") {
                //No ipv6
                //Has short ipv4 network speed testing (-r)
                $start_st = 36;
                $end_st = 43;
            } elseif ($array[40] == "Geekbench 5 Benchmark Test:\r") {
                //No ipv6
                //Has full ipv4 network speed testing
                $start_st = 36;
                $end_st = 38;
            } elseif ($array[40] == "iperf3 Network Speed Tests (IPv6):\r") {
                //HAS ipv6
                //Has short ipv4 & ipv6 network speed testing
                $start_st = 36;
                $end_st = 38;
            } elseif ($array[55] == "Geekbench 5 Benchmark Test:\r") {
                //HAS ipv6
                //Has full ipv4 & ipv6 network speed testing
                $start_st = 36;
                $end_st = 43;
            }
            for ($i = $start_st; $i <= $end_st; $i++) {
                if (strpos($array[$i], 'busy') !== false) {
                    //Has a "busy" result, No insert
                } else {
                    $data = explode(' ', preg_replace('!\s+!', ' ', $array[$i]));
                    $send_as_mbps = $this->networkSpeedAsMbps($this->yabsSpeedValues($data)['send_type'], $this->yabsSpeedValues($data)['send']);
                    $recieve_as_mbps = $this->networkSpeedAsMbps($this->yabsSpeedValues($data)['receive_type'], $this->yabsSpeedValues($data)['receive']);
                    $insert = $this->dbConnect()->prepare('INSERT IGNORE INTO `speed_tests` (`server_id`, `location`, `send`, `send_type`,`send_as_mbps`, `recieve`,`recieve_type`, `recieve_as_mbps`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                    $insert->execute([$this->item_id, $this->yabsSpeedLoc($data)['location'], $this->yabsSpeedValues($data)['send'], $this->yabsSpeedValues($data)['send_type'], $send_as_mbps, $this->yabsSpeedValues($data)['receive'], $this->yabsSpeedValues($data)['receive_type'], $recieve_as_mbps]);
                }
            }
            return true;
        } else {//Not formatted right
            return false;
        }
    }

}