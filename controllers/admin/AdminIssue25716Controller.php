<?php


use Symfony\Component\Form\Extension\Core\Type\FileType;
include (dirname(__file__).'../../../classes/IssuePic.php');

class AdminIssue25716Controller extends ModuleAdminController
{

    public static $photo_dir = _PS_IMG_DIR_ . 'issue25716';
    public static $access_rights = 0755;
    public static $source_index = _PS_PROD_IMG_DIR_ . 'index.php';

    public function __construct()
    {
        parent::__construct();
        // Base
        $this->bootstrap = true;
        $this->allow_export = true;

        $this->className = IssuePic::class;
        $this->table = IssuePic::$definition['table'];
        $this->identifier = IssuePic::$definition['primary'];

        // Photo directory
        $this->fieldImageSettings = ['name' => 'picture', 'dir' => 'issue25716'];

        // List view
        $this->_defaultOrderBy = 'a.id_issue25716';
        $this->_defaultOrderWay = 'ASC';
        $this->fields_list = [
            'id_issue25716' => ['title' => Context::getContext()->getTranslator()->trans('ID')],
            'name' => ['title' => Context::getContext()->getTranslator()->trans('Name')],
            'picture' => ['title' => Context::getContext()->getTranslator()->trans('Picture'), 'image' => 'issue25716', 'align' => 'center'],
        ];

        // CRUD
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->fields_form = [
            'legend' => [
                'title' => 'issue25716',
                'icon' => 'icon-list-ul'
            ],
            'input' => [
                ['name' => 'name', 'type' => 'text', 'label' => Context::getContext()->getTranslator()->trans('Name'), 'required' => true],
                ['name' => 'picture', 'type' => 'file', 'label' => Context::getContext()->getTranslator()->trans('Picture')],
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
            ]
        ];

        if (!file_exists(self::$photo_dir)) {
            $success = @mkdir(self::$photo_dir, self::$access_rights, true);
            $chmod = @chmod(self::$photo_dir, self::$access_rights);

            if (($success || $chmod)
                && !file_exists(self::$photo_dir . '/index.php')
                && file_exists(self::$source_index)) {
                return @copy(self::$source_index, self::$photo_dir . '/index.php');
            }
        }

    }


    
    // To see the pic in the CRUD form
    // Currently edition of item 7 of the array is hardcoded
    // Could be better
    public function renderForm()
    {
        if (!($issue25716 = $this->loadObject(true))) {
            return;
        }

        $image = self::$photo_dir . '/' . $issue25716->id . '.jpg';

        $image_url = ImageManager::thumbnail(
                $image,
                $this->table . '_' . (int) $issue25716->id . '.' . $this->imageType,
                350,
                $this->imageType,
                true,
                true
            );
        $image_size = file_exists($image) ? filesize($image) / 1000 : false;

        $photo_field = $this->fields_form['input'][1];
        $photo_field['display_image'] = true;
        $photo_field['image'] = $image_url ? $image_url : false;
        $photo_field['size'] = $image_size;

        $this->fields_form['input'][1] = $photo_field;

        return parent::renderForm();
    }


}
