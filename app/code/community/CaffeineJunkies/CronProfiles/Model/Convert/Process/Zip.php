<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Unzip a downloaded file (or any file in the batch.tmp)
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Convert_Process_Zip extends 
    CaffeineJunkies_CronProfiles_Model_Convert_Abstract
{
    /**
     * Default action code
     * @var string
     */
    protected $_actionCode = 'zip';
    
    /**
     * Default helper
     * @var string
     */
    protected $_defaultHelper = 'cronprofiles';

    /**
     * Extract the specified zip file and place it back as the tmp file
     * 
     * @return CaffeineJunkies_CronProfiles_Model_Convert_Process_Zip
     */
    public function extract()
    {
        //get the files from the IoAdaptor
        $batchModel = $this->_getBatchModel();
        
        //get the file information
        $_zipPath = $batchModel->getIoAdapter()->getFile(true);
        $_zipFile = $batchModel->getIoAdapter()->getFile();
        $_fileInArchive = $this->getVar('filename');
        
        //Open a file handler
        $_ioAdaptor = $this->_getIoAdaptor($_zipPath);
        $path = $_ioAdaptor->pwd().'/';
        
        //log some data
        $filesize = $this->getFileSize($path, $_zipFile);
        $message = $this->_getHelper()->__("Downloaded Zip File Size: %s",$filesize);
        $this->_throwNotice($message);
        
        //open the zip file
        $zip = new ZipArchive();
        $open = $zip->open($_zipPath);
        
        if(false === $open)
        {
            $message = $this->_getHelper()->__("Failed to open zip file");
            $this->_throwError($message);
        }
        
        //extract the file to the path.
        if($zip->extractTo($path, array($_fileInArchive)))
        {
            $filesize = $this->getFileSize($path, $_fileInArchive);
            $message = $this->_getHelper()->__("File Extracted %s Successfully (%s)", $_fileInArchive,$filesize);
            $this->_throwNotice($message);
            $_ioAdaptor->mv($_fileInArchive, $_zipFile);
            $return = true;
        }
        else
        {
            $message = $this->_getHelper()->__("Couldn't extract %s From Zip file.", $_fileInArchive);;
            $this->_throwError($message);
            $return = false;
        }
        $zip->close();
        //clear up some memory
        unset($zip);
        
        $this->setData($return);
        
        return $this;
    }
}