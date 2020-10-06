<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28/09/2018
 * Time: 14:34
 */

namespace app\models;


use yii\base\Model;

class DashboardForm extends Model
{

    public $fim;
    public $inicio;
    public $inicio_fim;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fim', 'inicio', 'inicio_fim'], 'safe'],
        ];
    }

    public function attributeLabels()
    {        
        return[
            'inicio' => 'Data Inicial',
            'fim' => 'Data Final'
        ];

    }

}