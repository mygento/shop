<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Process for splitting a large file into multiple smaller files. Useful if supplier issues massive CSVs
 * that take an age to import. Splitting them up can oftan speed this process up.
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Convert_Process_Separate extends 
    CaffeineJunkies_CronProfiles_Model_Convert_Abstract
{
    /**
     * Default action code
     * @var string
     */
    protected $_actionCode = 'separate';
    
    /**
     * Default helper
     * @var string
     */
    protected $_defaultHelper = 'cronprofiles';
    
    /**
     * Split the file into peice of x rows apeice
     * 
     * @return void
     */
    public function split()
    {
        //get the appropriate variables from the profile and previous action (zip in this case)
        $batchModel = $this->_getBatchModel();
        $_previousData = $this->getData();
        $_outputPattern = $this->getVar('output_file_pattern', false);
        $_outputPath = $this->getVar('output_path');
        $_inputFile = $this->getVar('input_file',$batchModel->getIoAdapter()->getFile(true));
        $_inputPath = $this->getVar('input_path',false);
        $_fileLength = $this->getVar('file_length', 500);
        $_numberBuffer = $this->getVar('number_buffer', 3);
        $_copyHeaders = $this->getVar('copy_headers', false);
        $_stripHeaders = $this->getVar('strip_headers', false);
        
        //verify that there's an output pattern
        if(!$_outputPattern)
        {
            $message = $this->_getHelper()->__('No Output File Pattern Specified');
            $this->_throwError($message);
        }
        
        //verify that the previous process was successful.
        if($_previousData === false)
        {
            $message = $this->_getHelper()->__('Previous process was unsuccessful.');
            $this->_throwError($message);
        }
        
        //get an Io adaptor for the input file
        if($_inputPath)
        {
            $_ioAdaptor = $this->_getIoAdaptor($_inputPath);
        }
        else
        {
            $_ioAdaptor = $this->_getIoAdaptor($_inputFile);
            $_inputPath = $_ioAdaptor->pwd();
            $_inputFile = str_replace($_inputPath.'/', '', $_inputFile);
        }
        
        //verify that the file exists.
        if($_ioAdaptor->fileExists($_inputFile) === false)
        {
            $message = $this->_getHelper()->__('File does not exist.');
            $this->_throwError($message);
        }
        
        $filesize = $this->getFileSize($_inputPath, $_inputFile);
        
        $message = $this->_getHelper()->__("Beginning File Split (%s)", $filesize);
        $this->_throwNotice($message);
        
        $_ioAdaptor->streamOpen($_inputFile, 'r');
        $_saveAdaptor = $this->_getIoAdaptor($_outputPath);
        $_currentLine = 0;
        $_fileCount = 0;
        $_totalFileSize = 0;
        
        while($line = $_ioAdaptor->streamRead())
        {
            $_currentLine++;
            $newFile = false;
            if((($_currentLine-1)%$_fileLength) == 0)
            {
                $_fileCount++;
                if($_currentLine != 1)
                {
                    $_saveAdaptor->streamClose();
                    $_totalFileSize += $this->getRawSize($_saveAdaptor->pwd(),$newFilename);
                }
                $newFile = true;
                $newFilename = str_replace('{count}', str_pad($_fileCount, $_numberBuffer, '0', STR_PAD_LEFT), $_outputPattern);
                $_saveAdaptor->streamOpen($newFilename);
                if($_copyHeaders && $newFile == true && isset($_headerLine))
                {
                    $_saveAdaptor->streamWrite($_headerLine);
                }
            }
            else
            {
                $newFile = false;
            }
            if($_copyHeaders && $_currentLine == 1)
            {
                $_headerLine = $line;
            }
            if($_stripHeaders && $_currentLine == 1)
            {
                continue;
            }
            $_saveAdaptor->streamWrite($line);
        }
        $_saveAdaptor->streamClose();
        $average = $this->formatSize($_totalFileSize/$_fileCount);
        
        $message = $this->_getHelper()->__("Split file into %s files.",$_fileCount);
        $this->_throwNotice($message);
        $message = $this->_getHelper()->__("Average file size: %s",$average);
        $this->_throwNotice($message);
        
        $this->setData(true);
    }
    
    public function join()
    {
    
    }
}