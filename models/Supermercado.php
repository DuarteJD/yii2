<?php

namespace app\models;
use yiibr\brvalidator\CnpjValidator;

use Yii;

/**
 * This is the model class for table "supermercado".
 *
 * @property int $id Código
 * @property string $nome Nome
 * @property string $razao_social Razão social
 * @property string $cnpj Cnpj
 * @property string $cep Cep
 * @property string $endereco Endereço
 * @property int|null $numero Número
 * @property string $bairro Bairro
 * @property string $cidade Cidade
 * @property string $estado estado
 * @property int $status Status
 *
 * @property Pedido[] $pedidos
 * @property Cidade $cidade
 */
class Supermercado extends \yii\db\ActiveRecord
{


    CONST STATUS_ACTIVE =1;
    CONST STATUS_INACTIVE =0;
    CONST STATUS_ACTIVE_STRING = 'Ativo';
    CONST STATUS_INACTIVE_STRING = 'Inativo';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supermercado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'razao_social', 'cnpj','cep', 'endereco', 'bairro', 'cidade','estado','status'], 'required'],
            [['status','numero'], 'integer'],
            [['nome', 'razao_social','cidade','estado'], 'string', 'max' => 100],
            [['cnpj', 'endereco', 'bairro', 'cep'], 'string', 'max' => 45],
            ['cnpj', CnpjValidator::className()],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'nome' => 'Nome',
            'razao_social' => 'Razão social',
            'cnpj' => 'Cnpj',
            'cep' => 'Cep',
            'endereco' => 'Endereço',
            'numero' => 'Número',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Pedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['supermercado_id' => 'id']);
    }


    public function getStatus () 
    {
        return [
            self::STATUS_INACTIVE => self::STATUS_INACTIVE_STRING,
            self::STATUS_INACTIVE => self::STATUS_ACTIVE_STRING,
            
        ];
    }
}
