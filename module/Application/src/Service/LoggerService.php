<?php
namespace Application\Service;

/**
 *
 * @author Douglas Santos <douglasrock15@hotmail.com>
 *
 */
class LoggerService
{
    const LOG_DB = 'db/';
    const LOG_PAYPAL = 'paypal/';
    const LOG_MAXIPAGO = 'maxipago/';
    const LOG_APPLICATION = 'application/';

    const CRITICAL = 'CRITICAL';
    const ERROR = 'ERROR';
    const WARNING = 'WARNING';
    const ALERT = 'ALERT';
    const INFO = 'INFO';
    const DEBUG = 'DEBUG';

    private $methodAndLine = '';
    private $fileName = null;

    /**
     * Write file
     * @param  String $strLogError Folder name to save in relative path
     * @param  String $strType Type to log
     * @param  String $strMessage   Message to be written
     * @return null              Without Return
     */
	public function save($strLogError, $strType, $strMessage)
    {
    	if(is_null($this->getFileName())){
    		$this->setFileName(date("d-m-Y"));
    	}
        $headersObj = apache_request_headers();
        $headers    = (array)$headersObj;
        $strMessage = 'Token Access: '.$headers['Authorization']." - ".$strMessage;

        $pathToSave = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/data/logs/";
        $fp = fopen($pathToSave. $strLogError.$strType.'_'.$this->getFileName().'.txt', "a+");
        fwrite($fp, date("H:i:s")." : ".$this->getMethodAndLine(). $strMessage."\r\n");
        fclose($fp);
    }

    /**
     * Set Method and Line where call log
     * @param String $strMethod Method name
     * @param String $strLine   Line number
     */
    public function setMethodAndLine($strMethod, $strLine)
    {
        $this->methodAndLine = $strMethod ." line:".$strLine." - ";
    }

    public function getMethodAndLine()
    {
        return $this->methodAndLine;
    }

    /**
     * Set name file to be writte
     * @param String $fileName name
     */
    public function setFileName($fileName)
    {
    	$this->fileName = $fileName;
    }

    public function getFileName()
    {
    	return $this->fileName;
    }
}