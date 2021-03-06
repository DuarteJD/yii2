<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class PrincipalModel extends \yii\db\ActiveRecord{

    CONST STATUS_ACTIVE = 1;
    CONST STATUS_INACTIVE = 0;
    CONST STATUS_ACTIVE_STRING = 'Ativo';
    CONST STATUS_INACTIVE_STRING = 'Inativo';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function fields()
    {
        $campos = parent::fields(); // TODO: Change the autogenerated stub
        if(isset($campos['created_at'])){
            $campos['created_at'] = function ($model){
                return date('Y-m-d H:i:s', $model->created_at);
            };
        }
        if(isset($campos['updated_at'])){
            $campos['updated_at'] = function ($model){
                return date('Y-m-d H:i:s', $model->updated_at);
            };
        }

        return $campos;
    }

    public function getStatus()
    {
        return [
            self::STATUS_INACTIVE => self::STATUS_INACTIVE_STRING,
            self::STATUS_ACTIVE => self::STATUS_ACTIVE_STRING,
        ];
    }
    
    public function atualizarCriarRegistro(){


        if($this->hasAttribute('criado_por')){

            $this->criado_por = Yii::$app->user->getId();

        }        

    }

}