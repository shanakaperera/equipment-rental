<?php

if (!function_exists('sanitize_output')) {

    /**
     * Minify html String.
     *
     * @param $buffer
     * @return string
     */
    function sanitize_output($buffer)
    {

        $replace = [
            '/<!--[^\[](.*?)[^\]]-->/s' => '',
            "/<\?php/"                  => '<?php ',
            "/\n([\S])/"                => ' $1',
            "/\r/"                      => '',
            "/\n/"                      => '',
            "/\t/"                      => ' ',
            '/ +/'                      => ' ',
        ];

        return preg_replace(array_keys($replace), array_values($replace), $buffer);

    }
}
