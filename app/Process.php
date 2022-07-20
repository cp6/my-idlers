<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Process
{
    public string $start_time;
    public string $end_time;

    public function startTimer(): void
    {
        $this->start_time = microtime(true);
    }

    public function stopTimer(): void
    {
        $this->end_time = microtime(true);
    }

    public function getTimeTaken(): float
    {//In seconds
        return ($this->end_time - $this->start_time) * 100;
    }

    public static function paymentTermIntToString(int $term): string
    {
        if ($term === 1) {
            return "p/m";
        } elseif ($term === 2) {
            return "p/qtr";
        } elseif ($term === 3) {
            return "p/hy";
        } elseif ($term === 4) {
            return "p/y";
        } elseif ($term === 5) {
            return "p/2y";
        } elseif ($term === 6) {
            return "p/3y";
        } else {
            return "unknown";
        }
    }

    private function floatValue(string $string): float
    {//Keeps only numbers and . AKA a float
        return preg_replace('/[^0-9,.]/', '', trim($string));
    }

    private function intValue(string $string): int
    {//Keeps only numbers AKA an int
        return (int)preg_replace('/[^0-9]/', '', trim($string));
    }

    private function removeFloat(string $string): string
    {//Removes float from a string
        return ltrim(preg_replace('/[^A-Za-z\-,.]/', '', $string), '.');
    }

    private function trimRemoveR(string $string): string
    {//Removes \r and does a trim()
        return trim(str_replace("\r", '', $string));
    }

    private function datatype(string $string): string
    {//Formats data type (ram and disk)
        if (str_contains($string, 'M')) {
            return 'MB';//Megabytes
        } elseif (str_contains($string, 'G')) {
            return 'GB';//Gigabytes
        } elseif (str_contains($string, 'K')) {
            return 'KB';//Kilobytes
        } elseif (str_contains($string, 'T')) {
            return 'TB';//TeraBytes
        } elseif (str_contains($string, 'B')) {
            return 'BT';//Bytes
        } else {
            return "GB";
        }
    }

    private function GBtoMB(string $gb): float
    {//Gigabyte to Megabyte conversion
        return ($gb * 1024);
    }

    private function TBtoGB(string $tb): float
    {//Terabyte to Gigabyte conversion
        return ($tb * 1024);
    }

    private function GBpstoMBps(string $gbps, bool $format = false): float
    {//Gigabits to Megabits
        if ($format) {
            return (float)number_format(((float)$gbps * 1024), 3);
        }
        return (float)$gbps * 1024;
    }

    private function diskSpeedAsMbps(string $type, string $value): float
    {//If value type GB/s convert to MB/s, KB/s to MB/s
        if ($type === "GB/s") {
            return $this->GBpstoMBps($value);
        }
        if ($type === "KB/s") {
            return (float)($value / 1024);
        }
        return $value;
    }

    private function networkSpeedAsMbps(string $type, string $value): float
    {//If value type GBps convert to MB/s
        if ($type === "GBps") {
            return $this->GBpstoMBps($value);
        }
        return $value;
    }

    private function yabsSpeedValues(array $data): array
    {//Formats YABs speed test for speed value and type as array
        $data = explode('|', implode($data));
        if ($data[2] === 'busy') {
            $send = $send_type = NULL;
        } else {
            $send = (float)$data[2];
            if ($this->removeFloat($data[2]) === 'Mbitssec') {
                $send_type = "MBps";
            } elseif ($this->removeFloat($data[2]) === 'Gbitssec') {
                $send_type = "GBps";
            } elseif ($this->removeFloat($data[2]) === 'Kbitssec') {
                $send_type = "KBps";
            } else {
                $send_type = $this->removeFloat($data[2]);
            }
        }
        if ($data[3] === 'busy') {
            $receive = $receive_type = NULL;
        } else {
            $receive = (float)$data[3];
            if ($this->removeFloat($data[3]) === 'Mbitssec') {
                $receive_type = "MBps";
            } elseif ($this->removeFloat($data[3]) === 'Gbitssec') {
                $receive_type = "GBps";
            } elseif ($this->removeFloat($data[3]) === 'Kbitssec') {
                $receive_type = "KBps";
            } else {
                $receive_type = $this->removeFloat($data[3]);
            }
        }
        return array('send' => $send, 'send_type' => $send_type, 'receive' => $receive, 'receive_type' => $receive_type);
    }

    private function yabsSpeedLoc(array $data): array
    {//Formats YABs speed test provider and location as array
        if ($data[1] === '|') {
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

    public function yabsOutputAsJson(string $server_id, string $data_from_form): array
    {
        $allowed_versions = ['v2021-12-28', 'v2022-02-18', 'v2022-04-30', 'v2022-05-06', 'v2022-06-11'];

        $file_name = date('Y') . '/' . date('m') . '/' . time() . '.txt';

        Storage::disk('local')->put($file_name, $data_from_form);

        $file = Storage::disk('local')->get($file_name);

        if ($file) {
            $array = explode("\n", $file);
            if (!Session::get('save_yabs_as_txt')) {//Check if we want YABs txt to stay
                Storage::disk('local')->delete($file_name);//Delete file
            }
        } else {
            return array('error_id' => 10, 'error_message' => 'Issue writing/reading txt file');
        }

        //dd($array);//Good for debugging the lines

        if (count($array) < 46) {
            return array('error_id' => 9, 'error_message' => 'Less than 46 lines');
        }

        if (str_contains($array[0], "# ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #\r")) {
            if ($array[1] !== "#              Yet-Another-Bench-Script              #\r") {
                return array('error_id' => 8, 'error_message' => 'Didnt copy output correctly');
            }

            $version_array = explode(' ', preg_replace('!\s+!', ' ', $this->trimRemoveR($array[2])));
            if (in_array($version_array[1], $allowed_versions, true)) {//YABs version is allowed
                if ($version_array[1] === 'v2022-05-06' || $version_array[1] === 'v2022-06-11') {//These versions added in more responses
                    $cpu = $this->trimRemoveR(str_replace(':', '', strstr($array[11], ': ')));
                    $cpu_spec = explode(' ', strstr($array[12], ': '));//: 2 @ 3792.872 MHz
                    $ram_line = $this->trimRemoveR(str_replace(':', '', strstr($array[15], ': ')));
                    $ram = (float)$ram_line;
                    $ram_type = $this->datatype($ram_line);
                    $swap_line = $this->trimRemoveR(str_replace(':', '', strstr($array[16], ': ')));
                    $swap = (float)$swap_line;
                    $swap_type = $this->datatype($swap_line);
                    $disk_line = $this->trimRemoveR(str_replace(':', '', strstr($array[17], ': ')));
                    $disk = (float)$disk_line;
                    $disk_type = $this->datatype($disk_line);
                    $io_3 = explode(' ', preg_replace('!\s+!', ' ', $array[27]));
                    $io_6 = explode(' ', preg_replace('!\s+!', ' ', $array[33]));
                    (str_contains($array[13], 'Enabled')) ? $aes_ni = true : $aes_ni = false;
                    (str_contains($array[14], 'Enabled')) ? $vm_amd_v = true : $vm_amd_v = false;
                    $uptime = str_replace(["Uptime     : ", "\r"], '', $array[10]);
                    $distro = str_replace(["Distro     : ", "\r"], '', $array[18]);
                    $kernel = str_replace(["Kernel     : ", "\r"], '', $array[19]);
                } else {
                    $cpu = $this->trimRemoveR(str_replace(':', '', strstr($array[10], ': ')));
                    $cpu_spec = explode(' ', strstr($array[11], ': '));//: 2 @ 3792.872 MHz
                    $ram_line = $this->trimRemoveR(str_replace(':', '', strstr($array[14], ': ')));
                    $ram = (float)$ram_line;
                    $ram_type = $this->datatype($ram_line);
                    $swap_line = $this->trimRemoveR(str_replace(':', '', strstr($array[15], ': ')));
                    $swap = (float)$swap_line;
                    $swap_type = $this->datatype($swap_line);
                    $disk_line = $this->trimRemoveR(str_replace(':', '', strstr($array[16], ': ')));
                    $disk = (float)$disk_line;
                    $disk_type = $this->datatype($disk_line);
                    $io_3 = explode(' ', preg_replace('!\s+!', ' ', $array[24]));
                    $io_6 = explode(' ', preg_replace('!\s+!', ' ', $array[30]));
                    (str_contains($array[12], 'Enabled')) ? $aes_ni = true : $aes_ni = false;
                    (str_contains($array[13], 'Enabled')) ? $vm_amd_v = true : $vm_amd_v = false;
                }
                $cpu_cores = $cpu_spec[1];
                $cpu_freq = $cpu_spec[3];


                $d4k_as_mbps = $this->diskSpeedAsMbps($io_3[3], $this->floatValue($io_3[2]));
                $d64k_as_mbps = $this->diskSpeedAsMbps($io_3[7], $this->floatValue($io_3[6]));
                $d512k_as_mbps = $this->diskSpeedAsMbps($io_6[3], $this->floatValue($io_6[2]));
                $d1m_as_mbps = $this->diskSpeedAsMbps($io_6[7], $this->floatValue($io_6[6]));
                $disk_test_arr = array(
                    '4k_total' => $this->floatValue($io_3[2]),
                    '4k_total_type' => $io_3[3],
                    '4k_total_mbps' => $d4k_as_mbps,
                    '64k_total' => $this->floatValue($io_3[6]),
                    '64k_total_type' => $io_3[7],
                    '64k_total_mbps' => $d64k_as_mbps,
                    '512k_total' => $this->floatValue($io_6[2]),
                    '512k_total_type' => $io_6[3],
                    '512k_total_mbps' => $d512k_as_mbps,
                    '1m_total' => $this->floatValue($io_6[6]),
                    '1m_total_type' => $io_6[7],
                    '1m_total_mbps' => $d1m_as_mbps,
                );

                if (isset($array[40])) {
                    if ($version_array[1] === 'v2022-05-06' || $version_array[1] === 'v2022-06-11') {
                        if ($array[43] === "Geekbench 5 Benchmark Test:\r") {
                            //No ipv6
                            //Has short ipv4 network speed testing (-r)
                            $has_ipv6 = false;
                            $start_st = 39;
                            $end_st = 41;
                            $gb_s = 47;
                            $gb_m = 48;
                            $gb_url = 49;
                        } elseif ($array[45] === "Geekbench 4 Benchmark Test:\r") {
                            return array('error_id' => 6, 'error_message' => 'GeekBench 5 only allowed');
                        } elseif ($array[45] === "Geekbench 5 test failed. Run manually to determine cause.\r") {
                            return array('error_id' => 7, 'error_message' => 'GeekBench test failed');
                        } elseif ($array[46] === "Geekbench 5 Benchmark Test:\r") {
                            //No ipv6
                            //Has full ipv4 network speed testing
                            $has_ipv6 = false;
                            $start_st = 39;
                            $end_st = 44;
                            $gb_s = 44;
                            $gb_m = 45;
                            $gb_url = 46;
                        } elseif ($array[47] === "Geekbench 5 Benchmark Test:\r") {
                            //No ipv6
                            //Has full ipv4 network speed testing
                            $has_ipv6 = false;
                            $start_st = 39;
                            $end_st = 45;
                            $gb_s = 51;
                            $gb_m = 52;
                            $gb_url = 53;
                        } elseif ($array[43] === "iperf3 Network Speed Tests (IPv6):\r") {
                            //HAS ipv6
                            //Has short ipv4 & ipv6 network speed testing
                            $has_ipv6 = true;
                            $start_st = 39;
                            $end_st = 41;
                            $gb_s = 55;
                            $gb_m = 56;
                            $gb_url = 57;
                        } elseif ($array[56] === "Geekbench 5 Benchmark Test:\r") {
                            //HAS ipv6
                            //Has full ipv4 & ipv6 network speed testing
                            $has_ipv6 = true;
                            $start_st = 39;
                            $end_st = 44;
                            $gb_s = 60;
                            $gb_m = 61;
                            $gb_url = 62;
                        } elseif ($array[59] === "Geekbench 5 Benchmark Test:\r") {
                            //HAS ipv6
                            //Has full ipv4 & ipv6 network speed testing
                            $has_ipv6 = true;
                            $start_st = 39;
                            $end_st = 45;
                            $gb_s = 63;
                            $gb_m = 64;
                            $gb_url = 65;
                        } else {
                            return array('error_id' => 5, 'error_message' => 'Not correct YABs command output');
                        }
                    } else {
                        if ($array[45] === "Geekbench 5 Benchmark Test:\r") {
                            //No ipv6
                            //Has short ipv4 network speed testing (-r)
                            $has_ipv6 = false;
                            $start_st = 36;
                            $end_st = 43;
                            $gb_s = 49;
                            $gb_m = 50;
                            $gb_url = 51;
                        } elseif ($array[45] === "Geekbench 4 Benchmark Test:\r") {
                            return array('error_id' => 6, 'error_message' => 'GeekBench 5 only allowed');
                        } elseif ($array[45] === "Geekbench 5 test failed. Run manually to determine cause.\r") {
                            return array('error_id' => 7, 'error_message' => 'GeekBench test failed');
                        } elseif ($array[40] === "Geekbench 5 Benchmark Test:\r") {
                            //No ipv6
                            //Has full ipv4 network speed testing
                            $has_ipv6 = false;
                            $start_st = 36;
                            $end_st = 38;
                            $gb_s = 44;
                            $gb_m = 45;
                            $gb_url = 46;
                        } elseif ($array[40] === "iperf3 Network Speed Tests (IPv6):\r") {
                            //HAS ipv6
                            //Has short ipv4 & ipv6 network speed testing
                            $has_ipv6 = true;
                            $start_st = 36;
                            $end_st = 38;
                            $gb_s = 52;
                            $gb_m = 53;
                            $gb_url = 54;
                        } elseif ($array[56] === "Geekbench 5 Benchmark Test:\r") {
                            //HAS ipv6
                            //Has full ipv4 & ipv6 network speed testing
                            $has_ipv6 = true;
                            $start_st = 36;
                            $end_st = 43;
                            $gb_s = 60;
                            $gb_m = 61;
                            $gb_url = 62;
                        } else {
                            return array('error_id' => 5, 'error_message' => 'Not correct YABs command output');
                        }
                    }
                } else {
                    return array('error_id' => 4, 'error_message' => 'Not correct formatting');
                }
                $geekbench_single = $this->intValue($array[$gb_s]);
                $geekbench_multi = $this->intValue($array[$gb_m]);
                $geek_full_url = explode(' ', preg_replace('!\s+!', ' ', $array[$gb_url]));
                $gb5_id = (int)substr($geek_full_url[3], strrpos($geek_full_url[3], '/') + 1);//
                $has_a_speed_test = false;

                ($ram_type === 'GB') ? $ram_mb = $this->GBtoMB($ram) : $ram_mb = $ram;
                ($swap_type === 'GB') ? $swap_mb = $this->GBtoMB($swap) : $swap_mb = $swap;
                ($disk_type === 'TB') ? $disk_gb = $this->TBtoGB($disk) : $disk_gb = $disk;

                $date = date_create($array[6]);

                $output = [
                    'id' => $server_id,
                    'has_ipv6' => $has_ipv6,
                    'output_date' => date_format($date, 'Y-m-d H:i:s'),
                    'process_date' => date('Y-m-d H:i:s'),
                    'cpu_cores' => (int)$cpu_cores,
                    'cpu_freq' => (float)$cpu_freq,
                    'cpu' => $cpu,
                    'ram' => $ram,
                    'ram_type' => $ram_type,
                    'ram_mb' => $ram_mb,
                    'swap' => $swap,
                    'swap_type' => $swap_type,
                    'swap_mb' => $swap_mb,
                    'disk' => $disk,
                    'disk_type' => $disk_type,
                    'disk_gb' => $disk_gb,
                    'aes' => $aes_ni,
                    'vm' => $vm_amd_v,
                    'GB5_single' => $geekbench_single,
                    'GB5_mult' => $geekbench_multi,
                    'GB5_id' => $gb5_id,
                    'uptime' => $uptime ?? null,
                    'distro' => $distro ?? null,
                    'kernel' => $kernel ?? null,
                ];

                $output['disk_speed'] = $disk_test_arr;

                $speed_test_arr = array();

                for ($i = $start_st; $i <= $end_st; $i++) {
                    if (str_contains($array[$i], 'busy')) {
                        //Has a "busy" result, No insert
                    } else {
                        $data = explode(' ', preg_replace('!\s+!', ' ', $array[$i]));
                        $send_as_mbps = $this->networkSpeedAsMbps($this->yabsSpeedValues($data)['send_type'], $this->yabsSpeedValues($data)['send']);
                        $recieve_as_mbps = $this->networkSpeedAsMbps($this->yabsSpeedValues($data)['receive_type'], $this->yabsSpeedValues($data)['receive']);
                        $speed_test_arr[] = array(
                            'location' => $this->yabsSpeedLoc($data)['location'],
                            'send' => $this->yabsSpeedValues($data)['send'],
                            'send_type' => $this->yabsSpeedValues($data)['send_type'],
                            'send_type_mbps' => $send_as_mbps,
                            'receive' => $this->yabsSpeedValues($data)['receive'],
                            'receive_type' => $this->yabsSpeedValues($data)['receive_type'],
                            'receive_type_mbps' => $recieve_as_mbps
                        );
                        $has_a_speed_test = true;
                    }
                }

                if ($has_a_speed_test) {
                    $output['network_speed'] = $speed_test_arr;
                }
                return $output;
            } else {
                return array('error_id' => 4, 'error_message' => 'Wrong YABs version');
            }
        } else {
            return array('error_id' => 3, 'error_message' => 'Didnt start at right spot');
        }
    }


}
