<?php
/*
 * ファイルパス：C:\xampp\htdocs\member\lib\Common.php
 * ファイル名：Common.php
 */
namespace member\lib;

class Common
{
    private $dataArr = [];

    private $errArr = [];

    private $db = NULL;

    // 初期化
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function errorCheck($dataArr)
    {
        $this->dataArr = $dataArr;

        // クラス内のメソッドを読み込む
        $this->createErrorMessage();

        $this->familyNameCheck();
        $this->firstNameCheck();
        $this->sexCheck();
        $this->birthCheck();
        $this->zipCheck();
        $this->addCheck();
        $this->passwordCheck();
        $this->telCheck();
        $this->mailCheck();
        $this->trafficCheck();

        return $this->errArr;
    }

    private function createErrorMessage()
    {
        foreach ($this->dataArr as $key => $val) {
            $this->errArr[$key] = '';
        }
    }

    private function familyNameCheck()
    {
        if ($this->dataArr['family_name'] === '') {
            $this->errArr['family_name'] = 'Please enter your family name';
        }
    }

    private function firstNameCheck()
    {
        // エラーチェックを入れる
        if ($this->dataArr['first_name'] === '') {
            $this->errArr['first_name'] = 'Please enter your first name';
        }
    }
    private function sexCheck()
    {
        if ($this->dataArr['sex'] === '') {
            $this->errArr['sex'] = 'Please select a gender';
        }
    }

    private function birthCheck()
    {
        if ($this->dataArr['year'] === '') {
            $this->errArr['year'] = 'Please select the year of birth';
        }
        if ($this->dataArr['month'] === '') {
            $this->errArr['month'] = 'Please select the month of birth';
        }
        if ($this->dataArr['day'] === '') {
            $this->errArr['day'] = 'Please select the date of birth';
        }
        if (checkdate($this->dataArr['month'], $this->dataArr['day'], $this->dataArr['year']) === false) {
            $this->errArr['year'] = 'Please enter the correct date';
        }
        if (strtotime($this->dataArr['year'] . '-' . $this->dataArr['month'] . '-' . $this->dataArr['day']) - strtotime('now') > 0) {
            $this->errArr['year'] = 'Please enter the correct date';
        }
    }

    private function zipCheck()
    {
        if (preg_match('/^[0-9]{3}$/', $this->dataArr['zip1']) === 0) {
            $this->errArr['zip1'] = 'Please enter the upper half of the zip code with 3 digits';
        }
        if (preg_match('/^[0-9]{4}$/', $this->dataArr['zip2']) === 0) {
            $this->errArr['zip2'] = 'Please enter 4 half-width numbers below the zip code';
        }
    }

    private function addCheck()
    {
        if ($this->dataArr['address'] === '') {
            $this->errArr['address'] = 'Please enter your address';
        }
    }
    private function passwordCheck()
    {
        if ($this->dataArr['password'] === '') {
            $this->errArr['password'] = 'Please enter your password';
        }
    }
    private function mailCheck()
    {
        if (preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+[a-zA-Z0-9\._-]+$/', $this->dataArr['email']) === 0) {
            $this->errArr['email'] = 'Please enter your email address in the correct format';
        }
        else{
            // emailの重複チェック
            $query = " SELECT "
                . "     mem_id "
                . " FROM "
                . "     member "
                . " WHERE "
                . "     email = ".$this->db->str_quote($this->dataArr['email']);

            $mailList = $this->db->select($query);
            if(count($mailList) > 0){
                $this->errArr['email'] = 'Your email address has already been registered';
            }
            $this->db->close();
        }
    }

    private function telCheck()
    {
        if (preg_match('/^\d{1,6}$/', $this->dataArr['tel1']) === 0 ||
            preg_match('/^\d{1,6}$/', $this->dataArr['tel2']) === 0 ||
            preg_match('/^\d{1,6}$/', $this->dataArr['tel3']) === 0 ||

            strlen($this->dataArr['tel1'] . $this->dataArr['tel2'] . $this->dataArr['tel3']) >= 12) {
            $this->errArr['tel1'] = 'Please enter a phone number within 11 half-width numbers';
        }
    }

    private function trafficCheck()
    {
        if ($this->dataArr['traffic'] === []) {
            $this->errArr['traffic'] = 'Please enter at least one transportation';
        }
    }

    public function getErrorFlg()
    {
        $err_check = true;
        foreach ($this->errArr as $key => $value) {
            if ($value !== '') {
                $err_check = false;
            }
        }
        return $err_check;
    }
}
