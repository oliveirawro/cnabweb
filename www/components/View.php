<?php

namespace app\components;
use Yii;
use yii\helpers\Html;



class View extends \yii\web\View
{
    /**
     * @var array context menu items
     */
    private $_menu = [];
    /**
     * @var array context menu items
     */
    private $_menuRight = [];
    /**
     * @var array context action menu items
     */
    private $_actionMenu = [];
    /**
     * @var string o título curto da página (somente a parte "{action}" da função setPageTitle)
     */
    public $shortTitle = '';
    /**
     * @var boolean indica se é para mostrar o botão de retornar no menu de ações
     */
    public $showReturnActionButton = true;

    /**
     * @param string|array $title o título da página pode ser uma string com o título ou
     * um array no seguinte formato:
     * [
     *    '{action}' => string, // a ação que está sendo executada pelo sistema
     *    '{text}' => string, // algum text extra a aparecer no título
     *    '{sysname} => string, // o nome do sistema, por padrão \app\models\System::NAME
     *    '{coname) => string, // o noem da companhia, por padrão \app\models\System::ENTERPRISE_NAME
     * ]
     * @param string $glue a string que irá juntar cada parte do título. Por padrão é: " | "
     */
    public function setPageTitle($title = [], $glue = ' | ')
    {
        if (is_string($title))
            $title = ['{action}' => $title];

        // o template completo é: '{action} | {text} | {sysname} | {coname}'
        $keywords = ['{action}','{text}','{sysname}','{coname}'];

        if (!isset($title['{sysname}'])) // nome do sistema
            $title['{sysname}'] = System::NAME;

        if (!isset($title['{coname}'])) // nome da empresa (dona do sistema)
            $title['{coname}'] = System::ENTERPRISE_NAME;

        $this->shortTitle = $title['{action}'];

        $template = implode($glue, array_intersect($keywords, array_keys($title)));

        $pageTitle = strtr($template, $title);

        $this->title = $pageTitle;
    }

    /**
     * Retorna um array com as configurações do menu de ações do sistema
     * @return array com os itens do menu
     */
    public function getActionMenu()
    {
        return $this->_actionMenu;
    }

    /**
     * Define o menu de ações do sistema
     * @param array $actionMenu os itens do menu
     */
    public function setActionMenu($actionMenu)
    {
        $this->_actionMenu = $actionMenu;
    }

    /**
     * Retorna um array com as configurações do menu do sistema
     * @return array com os itens do menu
     */
    public function getMenu()
    {

        //MENU SUPERIOR DO SISTEMA
        $this->_menu = [


            [
                'label' => Yii::t('app', 'Home'),
                'url' => ['site/home'],
            ],

            [
                'label' => Yii::t('app', 'Arquivos'),
                'url' => ['load/index'],
            ],


        ];

        return $this->_menu;
    }


    //**************** COMMON FUNCTIONS *******************//


}





