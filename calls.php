<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once('class.php');
$idle = new idlers();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['type'])) {
        if ($_GET['type'] == 'server') {
            echo $idle->serverData($_GET['id']);
        } elseif ($_GET['type'] == 'search') {
            header('Content-Type: text/html; charset=utf-8');
            echo $idle->searchResults($_GET['value']);
        } elseif ($_GET['type'] == 'shared_hosting') {
            echo $idle->sharedHostingData($_GET['id']);
        } elseif ($_GET['type'] == 'domain') {
            echo $idle->domainData($_GET['id']);
        } elseif ($_GET['type'] == 'yabsModal') {
            header('Content-Type: text/html; charset=utf-8');
            echo $idle->showYabsModal($_GET['id']);//Not used anymore. Still here for debugging
        } elseif ($_GET['type'] == 'infoCard') {
            header('Content-Type: text/html; charset=utf-8');
            echo $idle->infoCard();//Info card for the "info" tab
        } elseif ($_GET['type'] == 'autocomplete') {
            if ($_GET['input'] == 'location') {
                $idle->locationsAutoCompleteGET($_GET['value']);//Auto complete locations input
            } elseif ($_GET['input'] == 'provider') {
                $idle->providersAutoCompleteGET($_GET['value']);//Auto complete providers input
            }
        } elseif ($_GET['type'] == 'view_more_modal') {
            header('Content-Type: text/html; charset=utf-8');
            if ($_GET['value'] == 'server') {
                $idle->viewMoreModal($_GET['id']);//View more details modal
            } elseif ($_GET['value'] == 'shared') {
                $idle->viewMoreSharedHostingModal($_GET['id']);//View more details modal
            } elseif ($_GET['value'] == 'domain') {
                $idle->viewMoreDomainModal($_GET['id']);//View more details modal
            }
        } elseif ($_GET['type'] == 'dns_search') {
            header('Content-Type: text/html; charset=utf-8');
            echo $idle->getIpForDomain($_GET['hostname'], $_GET['dns_type']);
        } elseif ($_GET['type'] == 'asn_search') {
            header('Content-Type: text/html; charset=utf-8');        
            echo $idle->getAsnForIp($_GET['ip']);
        } elseif ($_GET['type'] == 'asn_name') {
            header('Content-Type: text/html; charset=utf-8');        
            echo $idle->getAsnName($_GET['asn']);            
        } elseif ($_GET['type'] == 'check_up') {
            echo $idle->checkIsUp($_GET['host']);
        } elseif ($_GET['type'] == 'object_cards') {
            header('Content-Type: text/html; charset=utf-8');
            echo $idle->objectCards();
        } elseif ($_GET['type'] == 'object_tables') {
            header('Content-Type: text/html; charset=utf-8');
            echo $idle->objectTables();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_form'])) {
        header('Content-Type: text/html; charset=utf-8');
        echo $idle->orderTable($_POST['order_by']);//Returns order table
    } else {
        if (isset($_POST['action']) && $_POST['action'] == 'insert') {//From an insert 'type' form
            $insert = new itemInsert($_POST);
            if (isset($_POST['from_yabs'])) {//From add form YABs
                $insert->insertBasicWithYabs();//Insert basic data from form
                $insert->insertYabsData();//Insert YABs data from the form
            } elseif (isset($_POST['manual'])) {//From add form manual
                $insert->insertBasic();
            } elseif (isset($_POST['shared_hosting_form'])) {//From shared hosting form
                $insert->insertSharedHosting();
            } elseif (isset($_POST['domain_form'])) {//From domain form
                $insert->insertDomain();
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'update') {
            $update = new itemUpdate($_POST);
            if (isset($_POST['me_delete']) || isset($_POST['sh_me_delete']) || isset($_POST['d_me_delete'])) {//Delete object
                $update->deleteObjectData();
            } elseif ($_POST['type'] == 'server_modal_edit') {//Update the server info
                $update->updateServerFromModal();
                $update->updateServerPricingFromModal();
                if (!is_null($_POST['me_yabs']) && !empty($_POST['me_yabs'])) {
                    $update->updateYabsData();
                }
            } elseif ($_POST['type'] == 'shared_hosting_modal_edit') {//Update the shared hosting info
                $update->updateSharedHostingFromModal();
                $update->updateSharedHostingPricingFromModal();
            } elseif ($_POST['type'] == 'domain_modal_edit') {//Update the domain info
                $update->updateDomainFromModal();
                $update->updateDomainPricingFromModal();
            }
        }
        header('Location:index.php');
        die();
    }
}