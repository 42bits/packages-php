<?php
namespace app\packages\Http;

use Exception;

class Http
{
    private $_start = 0;
    private $_end = 0;

    private function _beforeAction()
    {
        $this->_start = microtime(true) * 1000;
    }

    private function _afterAction()
    {
        $this->_end = microtime(true) * 1000;

        $cost = round($this->_end - $this->_start);
        yDebug($cost);

        if ($cost > 100) {
            yWarning('cost time from curl : '.$cost);
        }
    }

    /**
     * post 请求
     * @param $url
     * @param null $data
     * @param array $header
     * @return mixed
     * @throws Exception
     */
    public function post($url, $data = null, $header = [])
    {
        $this->_beforeAction();
        //yInfo('http_post: -d "' . $this->getUri($data) . '" "' . $url . '"');

        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_POST, 1); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名,http_build_query是为了支持多维数组
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//成功时不返回true，只返回结果
        //不进行ssl验证，为了https调试
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            yError('curl error number '. curl_error($ch));
        }

        curl_close($ch);
        $this->_afterAction();

        return $output;
    }

    /**
     * put 请求
     * @param $url
     * @param null $data
     * @param array $header
     * @return mixed
     * @throws Exception
     */
    public function put($url, $data = null, $header = [])
    {
        $this->_beforeAction();
        //yInfo('http_post: -d "' . $this->getUri($data) . '" "' . $url . '"');

        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名,http_build_query是为了支持多维数组
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//成功时不返回true，只返回结果
        //不进行ssl验证，为了https调试
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            yError('curl error number '. curl_error($ch));
        }

        curl_close($ch);
        $this->_afterAction();

        return $output;
    }

    /**
     * post上传文件
     * @param $url
     * @param null $data
     * @param array $header
     * @return mixed
     * @throws Exception
     */
    public function postWithFile($url, $data = null, $header = [])
    {
        $this->_beforeAction();
        yInfo("http_post_with_file: " . $url);

        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        if (defined('CURLOPT_SAFE_UPLOAD')) {
            //5.6以后必须指定
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        }
        curl_setopt($ch, CURLOPT_POST, 1); //启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //since 5.2 上传文件必须是一个数组
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//成功时不返回true，只返回结果
        //不进行ssl验证，为了https调试
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            yError('curl error number '. curl_error($ch));
        }

        curl_close($ch);
        $this->_afterAction();

        return $output;
    }

    /**
     * get 请求
     * @param $url string 请求地址
     * @param null $data 需要跟在地址栏上的参数
     * @return mixed
     * @throws Exception
     */
    public function get($url, $data = null)
    {
        $this->_beforeAction();
        if (!empty($data)) {
            $url = $url . '?' . $this->getUri($data);
        }
        yInfo("http_get: " . $url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $i = 0;
        //无响应重试三次
        while (!$output = curl_exec($ch)) {
            $i++;
            yWarning('send get request to ' . $url . ' for ' . $i . ' times');
            if ($i > 3) {
                break;
            }
            usleep(200000);//微秒 0.2 秒
        }

        if (curl_errno($ch)) {
            yError('curl error number '. curl_error($ch));
        }

        curl_close($ch);

        $this->_afterAction();

        return $output;
    }

    /**
     * delete 请求
     * @param $url
     * @param null $data
     * @param array $header
     * @return mixed
     * @throws Exception
     */
    public function delete($url, $data = null, $header = [])
    {
        $this->_beforeAction();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $i = 0;
        //无响应重试三次
        while (!$output = curl_exec($ch)) {
            $i++;
            if ($i > 3) {
                break;
            }
            usleep(200000);
        }

        if (curl_errno($ch)) {
            yError('curl error number '. curl_error($ch));
        }

        curl_close($ch);
        $this->_afterAction();

        return $output;
    }

    /**
     * @param $params_array
     * @return string
     */
    private function getUri($params_array)
    {
        return http_build_query($params_array);
    }

    /**
     * @return string
     */
    public function getIp()
    {
        $ip_address = '0.0.0.0';
        if (!empty($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip_address = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match(
                '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',
                $_SERVER['HTTP_X_FORWARDED_FOR']
            )
        ) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) AND isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if ($ip_address === 'Unknown') {
            $ip_address = '0.0.0.0';

            return $ip_address;
        }
        if (strpos($ip_address, ',') !== 'Unknown') {
            $x          = explode(',', $ip_address);
            $ip_address = trim(end($x));
        }

        return $ip_address;
    }

    /**
     * 手机设备识别
     * @return bool
     */
    public function isMobile()
    {
        $useragent               = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $useragent_commentsblock = preg_match('|\(.*?\)|', $useragent, $matches) > 0 ? $matches[0] : '';
        $mobile_os_list          = array(
            'Google Wireless Transcoder',
            'Windows CE',
            'WindowsCE',
            'Symbian',
            'Android',
            'armv6l',
            'armv5',
            'Mobile',
            'CentOS',
            'mowser',
            'AvantGo',
            'Opera Mobi',
            'J2ME/MIDP',
            'Smartphone',
            'Go.Web',
            'Palm',
            'iPAQ'
        );
        $mobile_token_list       = array(
            'Profile/MIDP',
            'Configuration/CLDC-',
            '160×160',
            '176×220',
            '240×240',
            '240×320',
            '320×240',
            'UP.Browser',
            'UP.Link',
            'SymbianOS',
            'PalmOS',
            'PocketPC',
            'SonyEricsson',
            'Nokia',
            'BlackBerry',
            'Vodafone',
            'BenQ',
            'Novarra-Vision',
            'Iris',
            'NetFront',
            'HTC_',
            'Xda_',
            'SAMSUNG-SGH',
            'Wapaka',
            'DoCoMo',
            'iPhone',
            'iPod'
        );
        $found_mobile            = $this->_CheckSubstrs($mobile_os_list, $useragent_commentsblock) ||
            $this->_CheckSubstrs($mobile_token_list, $useragent);
        if ($found_mobile) {
            return true;
        } else {
            return false;
        }
    }

    private function _CheckSubstrs($substrs, $text)
    {
        foreach ($substrs as $substr) {
            if (false !== strpos($text, $substr)) {
                return true;
            }
        }

        return false;
    }

}