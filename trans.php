<?php
    /**
     * [trans description]
     * @param string $source Source exchange currency
     * @param string $target Target exchange currency
     * @param string $money Exchange money
     * @return json Result of api data
     */
    public function trans() {
        $rates = $this->_get_input_json();
        $allow_currencies = array_keys($rates["currencies"]);
        $source = $this->input->get("source");
        $target = $this->input->get("target");
        $money  = $this->input->get("money");
        if ( ! $source || ! $target || ! $money) {
            $this->_show_error('4000', 'Invalid parameter');
        }
        if ( ! in_array($source, $allow_currencies) || ! in_array($target, $allow_currencies)) {
            $this->_show_error('4001', 'Unknown currency');
        }
        if ( ! is_numeric($money)) {
            $this->_show_error('4002', 'Money have to be number');
        }
        $exchanged = $money * $rates["currencies"][$source][$target];

        $data = [
            "source" => $source,
            "target" => $target,
            "money" => number_format($money, 2),
            "exchanged" => number_format($exchanged, 2),
        ];
        $this->_show_resp($data);
    }

    /**
     * [_get_input_json description]
     * @return [type] [description]
     */
    private function _get_input_json() {
        $raw_data = $this->input->raw_input_stream;
        if (empty($raw_data)) {
            $this->_show_error('4001', 'invalid payload format');
        }
        $params = json_decode($raw_data, true);
        if ( ! is_array($params)) {
            $this->_show_error('4002', 'invalid json structure');
        }
        return $params;
    }

    /**
     * [_show_resp description]
     * @param  [type] $data [description]
     */
    private function _show_resp($data = []) {
        if (count($data) == 0) {
            $data = new stdClass();
        }

        $response = [
            'error' => [
                'code' => '0',
                'message' => '',
            ],
            'data' => $data,
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        exit;
    }

    /**
     * [_show_error description]
     * @param  [type] $code    [description]
     * @param  [type] $message [description]
     */
    private function _show_error($code, $message) {
        $response = [
            'error' => [
                'code'    => strval($code),
                'message' => $message,
            ],
            'data' => new stdClass(),
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        exit;
    }
?>
