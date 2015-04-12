<html>
    <body>
        <pre>
            <?php
            define("_ZEXEC", 1);
            require_once 'base.php';

            function abc() {
                
            }
            $res = Base::curl_request("http://202.204.105.22/academic/j_acegi_security_check", "", [
                        //CURLOPT_HEADER => true,
                        CURLOPT_HEADERFUNCTION => abc,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_AUTOREFERER => true,
                        CURLOPT_MAXREDIRS => 5,
                        CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.3.18 (KHTML, like Gecko) Version/8.0.3 Safari/600.3.18"
            ]);
            $matches = array();
            $charset = "UTF-8";
            if (preg_match_all('/charset=(.*)\b/i', $res, $matches) > 0) {
                if (count($matches[1] > 1)) {
                    $charset = $matches[1][count($matches[1]) - 2];
                } elseif (count($matches[1] == 1)) {
                    $charset = $matches[1][count($matches[1]) - 1];
                }
            }
            $res = trim((iconv($charset, "UTF-8//IGNORE", $res)));

            // 初始化CURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
// 获取头部信息
            curl_setopt($ch, CURLOPT_HEADER, 1);
// 返回原生的（Raw）输出
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 执行并获取返回结果
            $content = curl_exec($ch);
// 关闭CURL
            curl_close($ch);
// 解析HTTP数据流
            list($header, $body) = explode("\r\n\r\n", $content);
// 解析COOKIE
            preg_match("/set\-cookie:([^\r\n]*)/i", $header, $matches);
// 后面用CURL提交的时候可以直接使用
// curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            $cookie = $matches[1];


            echo htmlspecialchars($res);
            ?>
        </pre>
    </body>
</html>
