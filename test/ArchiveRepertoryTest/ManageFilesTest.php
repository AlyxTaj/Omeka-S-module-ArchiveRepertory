<?php
namespace OmekaTest;
use OmekaTestHelper\File\MockFileWriter;
use OmekaTestHelper\Controller\OmekaControllerTestCase;
use Omeka\Test\AbstractHttpControllerTestCase;
use Omeka\Entity\Item;
use Omeka\Entity\Value;
use Omeka\Entity\Property;
use Omeka\File\File;
use Omeka\ArchiveRepertory\Module;
use Omeka\Entity\Media;
use Omeka\File\ArchiveManager as ArchiveManager;



class ArchiveRepertory_ManageFilesTest extends  OmekaControllerTestCase
{
    protected $_pathsByType = [
                               'original' => 'original',
                               'fullsize' => 'large',
                               'thumbnail' => 'medium',
                               'square_thumbnail' => 'square',
    ];
    protected $fileStorageId;
    protected $fileExtension;
    protected $_fileUrl;
    protected $_storagePath;
    protected $module;

    public function setConfig() {
        $config = include __DIR__ . '/../../config/module.config.php';
        $config['local_dir']=OMEKA_PATH.'/files';
        $this->_storagePath=$config['local_dir'];
        \ArchiveRepertory\Module::setConfig($config);
        $this->filewriter = new MockFileWriter();
        \ArchiveRepertory\Module::setFileWriter($this->filewriter);
    }

    public function setUp() {

        $this->loginAsAdmin();

        $manager = $this->getApplicationServiceLocator()->get('Omeka\ModuleManager');
        $module = $manager->getModule('ArchiveRepertory');
        if ($module->getState() == \Omeka\Module\Manager::STATE_ACTIVE) {
            $manager->uninstall($module);
        }

        $this->setConfig();

        $manager->install($module);
        $this->mockFileManager= MockFileManager::class;
        \ArchiveRepertory\File\OmekaRenameUpload::setFileWriter($this->filewriter);
        \ArchiveRepertory\Service\FileArchiveManagerFactory::setFileManager($this->mockFileManager);
        \OmekaTestHelper\File\Store\LocalStore::setFileWriter($this->filewriter);
        \ArchiveRepertory\Media\Ingester\UploadAnywhere::setFileInput(new MockFileInput());
        parent::setUp();

        $this->module= $this->getApplicationServiceLocator()->get('ModuleManager')->getModule('ArchiveRepertory');

        $this->item = new Item;
        $this->persistAndSave($this->item);
        $this->loginAsAdmin();

        $this->fileStorageId = __DIR__ . '/_files/image_test';
        $this->fileExtension = 'png';
        $this->_fileUrl = $this->fileStorageId . '.' . $this->fileExtension;
    }


    public function tearDown() {
        $this->loginAsAdmin();
    }

    public function getFileManager() {
        $fileData= file_get_contents($this->_fileUrl);
        $fileManager = $this->getApplicationServiceLocator()->get('Omeka\File\Manager');

        $media = new Media;
        $media->setStorageId($this->fileStorageId);
        $media->setExtension($this->fileExtension);
        $media->setItem($this->item);
        $fileManager->setMedia($media);
        return $fileManager;
    }

    /** @test **/
    public function testWithOptionKeepOriginalNameInsertFile()
    {

        $file = new File($this->_fileUrl);
        $file->setSourceName('originalname.png');

        $this->assertEquals('originalname.png', $this->getFileManager()->getStorageName($file));
    }

    /** @test */
    public function testWithOptionNoKeepOriginalFileName() {
        $settings = $this->getServiceLocator()->get('Omeka\Settings');
        $settings->set('archive_repertory_file_keep_original_name', '0');
        $file = new File($this->_fileUrl);
        $this->assertNotEquals('originalname.png', $this->getFileManager()->getStorageName($file));
    }



    /** @test */
    public function testStorageBasePathWithItemId() {
        $settings = $this->getServiceLocator()->get('Omeka\Settings');
        $settings->set('archive_repertory_item_folder', 'id');
        $file = new File($this->_fileUrl);
        $file->setSourceName('image_test.png');
        $storageFilepath = $this->item->getId()
            . DIRECTORY_SEPARATOR
            . pathinfo($this->_fileUrl, PATHINFO_BASENAME);
        $fileManager=$this->getFileManager();
        $this->assertEquals($storageFilepath, $fileManager->getStoragePath('',$fileManager->getStorageName($file)));
    }



    /** @test */
    public function testStorageBasePathWithItemNone() {
        $settings = $this->getServiceLocator()->get('Omeka\Settings');
        $settings->set('archive_repertory_item_folder', '');
        $file = new File($this->_fileUrl);
        $file->setSourceName('image_test.png');
        $storageFilepath = DIRECTORY_SEPARATOR . pathinfo($this->_fileUrl, PATHINFO_BASENAME);
        $fileManager=$this->getFileManager();

        $this->assertEquals($storageFilepath, $fileManager->getStoragePath('',$fileManager->getStorageName($file)));

    }



    protected function getUpload($name, $url) {
        $upload = new \Zend\Stdlib\Parameters([
                                               'file' => [[
                                                           'name' => $name,
                                                           'type' => 'image/png',
                                                           'tmp_name' => $url,

                                                           'content' => file_get_contents($url),
                                                           'error' => 0,
                                                           'size' => 1999]

                                               ]
                                               ]);
        $this->getRequest()->setFiles($upload);

        return $upload;
    }

    protected function updateItem($id, $title,$upload,$file_index=0) {
        $api = $this->getApplicationServiceLocator()->get('Omeka\ApiManager');
        return $api->update('items', $id, [
                                           'dcterms:identifier' => [
                                                                    [
                                                                     'type' => 'literal',
                                                                     'property_id' => '10',
                                                                     '@value' => 'item1',
                                                                    ],
                                           ],
                                           'dcterms:title' => [
                                                               [
                                                                'type' => 'literal',
                                                                'property_id' => '1',
                                                                '@value' => $title,
                                                               ],
                                           ],

                                           'o:media' => [
                                                         [
                                                          'o:ingester' => 'upload',
                                                          'file_index' => $file_index,
                                                          'dcterms:identifier' => [
                                                                                   [
                                                                                    'type' => 'literal',
                                                                                    'property_id' => 10,
                                                                                    '@value' => 'media1',
                                                                                   ],
                                                          ],
                                                         ],
                                           ]]
                            ,$upload);


    }


    protected function createMediaItem($title,$upload,$file_index=0) {
        $api = $this->getApplicationServiceLocator()->get('Omeka\ApiManager');
        return $api->create('items', [
                                      'dcterms:identifier' => [
                                                               [
                                                                'type' => 'literal',
                                                                'property_id' => '10',
                                                                '@value' => 'item1',
                                                               ],
                                      ],
                                      'dcterms:title' => [
                                                          [
                                                           'type' => 'literal',
                                                           'property_id' => '1',
                                                           '@value' => $title,
                                                          ],
                                      ],

                                      'o:media' => [
                                                    [
                                                     'o:ingester' => 'upload',
                                                     'file_index' => $file_index,
                                                     'dcterms:identifier' => [
                                                                              [
                                                                               'type' => 'literal',
                                                                               'property_id' => 10,
                                                                               '@value' => 'media1',
                                                                              ],
                                                     ],
                                                    ],
                                      ],
                                      ],$upload);

    }
    protected function createUrlItem($title) {
        $api = $this->getApplicationServiceLocator()->get('Omeka\ApiManager');
        $media_url = 'http://farm8.staticflickr.com/7495/28077970085_4d976b3c96_z_d.jpg';

        return $api->create('items', [
                                      'dcterms:identifier' => [
                                                               [
                                                                'type' => 'literal',
                                                                'property_id' => '10',
                                                                '@value' => 'item1',
                                                               ],
                                      ],
                                      'dcterms:title' => [
                                                          [
                                                           'type' => 'literal',
                                                           'property_id' => '1',
                                                           '@value' => $title,
                                                          ],
                                      ],
                                      'o:media' => [
                                                    [
                                                     'o:ingester' => 'url',
                                                     'ingest_url' => $media_url,
                                                     'dcterms:identifier' => [
                                                                              [
                                                                               'type' => 'literal',
                                                                               'property_id' => 10,
                                                                               '@value' => 'media1',
                        ],
                    ],
                ],
                                      ]]);

    }



    /** @test */
    public function testStorageBasePathWithIdDirectory() {
        $settings = $this->getServiceLocator()->get('Omeka\Settings');
        $settings->set('archive_repertory_item_folder', 'id');
        $settings->set('archive_repertory_file_keep_original_name', '1');
        $upload = $this->getUpload('image_uploaded.png', $this->_fileUrl);

        $item = $this->createMediaItem('My_title?',$upload);
        $file = new File($this->_fileUrl);
        $file->setSourceName('image_uploaded.png');
        $storageFilepath = $item->getContent()->id().DIRECTORY_SEPARATOR.'image_uploaded.png';
        $fileManager = $this->getServiceLocator()->get('Omeka\File\Manager');
        $this->assertEquals($storageFilepath, $fileManager->getStoragePath('',$fileManager->getStorageName($file)));
    }


    protected function postItem($item) {
        $this->postDispatch('/admin/item/'.$item->getContent()->id().'/edit', [
                                                                               'dcterms:identifier' => [
                                                                                                        [
                                                                                                         'type' => 'literal',
                                                                                                         'property_id' => '10',
                                                                                                         '@value' => 'item1',
                                                                                                        ],
                                                                               ],
                                                                               'dcterms:title' => [
                                                                                                   [
                                                                                                    'type' => 'literal',
                                                                                                    'property_id' => '1',
                                                                                                    '@value' => 'Itemee 1',
                                                                                                   ],
                                                                               ],
                                                                               'file' =>                 file_get_contents($this->_fileUrl),
                                                                               'csrf' => (new \Zend\Form\Element\Csrf('csrf'))->getValue(),
                                                                               'o:media'=> [[
                                                                                             'o:ingester' => 'upload',
                                                                                             'o:is_public'=>'1',
                                                                                             'file_index'=> 1,
                                                                                   ]]

                                                                               ]);



    }


    /**
     * @test
     */
    public function testInsertDuplicateFile()
    {
        $settings = $this->getServiceLocator()->get('Omeka\Settings');
        $settings->set('archive_repertory_file_keep_original_name', '1');
        $settings->set('archive_repertory_item_folder', '1');
        $storageFilepath = 'Item_1/photo.png';
        $this->filewriter->addFile($this->_storagePath.'/original/photo.png');
        $this->filewriter->addFile($this->_storagePath.'/original/photo.1.png');
        $this->assertEquals('./photo.2.png',$this->module->checkExistingFile('photo.png'));
    }


    /**
     * Check simultaneous change of identifier and collection of the item.
     */
    protected function _testChangeIdentifierAndItem()
    {

        $files = $this->item->getFiles();
        foreach ($files as $key => $file) {
            $this->_checkFile($file);
        }
    }

    /**
     * Check if file and derivatives exist really.
     */
    protected function _checkFile($file)
    {
        foreach ($this->_pathsByType as $type => $path) {
            $storageFilepath = $this->_storagePath . DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR . $file->filename();
            if ($type != 'original')
                $storageFilepath=str_replace('.png','.jpg',$storageFilepath);
            $this->assertTrue($this->filewriter->fileExists($storageFilepath));
        }
    }

}



class MockFileInput extends \Zend\InputFilter\FileInput {
    public function isValid($context=null) {
        return true;
    }
}


class MockFileManager extends \ArchiveRepertory\File\ArchiveManager {
    public function storeThumbnails(File $file) {
        return true;
    }


}