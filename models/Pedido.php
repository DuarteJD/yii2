<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property int $id 
 * @property string $data_pedido  
 * @property int $cliente_id 
 * @property string $valor_total   
 * @property string $data_retirada  
 * @property int $status 
 * @property int $supermercado_id 
 *
 * @property Usuario $cliente
 * @property Supermercado $supermercado
 * @property PedidoHasProduto[] $pedidoHasProdutos
 */
class Pedido extends PrincipalModel
{
    
    public static function tableName()
    {
        return 'pedido';
    }

    public function extraFields()
    {
        return ['cliente', 'supermercado', 'pedidoHasProdutos'];
    }

    public function rules()
    {
        return [
            [['data_pedido', 'cliente_id', 'valor_total', 'data_retirada', 'status', 'supermercado_id'], 'required'],
            [['data_pedido', 'data_retirada'], 'safe'],
            [['cliente_id', 'status', 'supermercado_id'], 'integer'],
            [['valor_total'], 'string', 'max' => 45],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['supermercado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supermercado::className(), 'targetAttribute' => ['supermercado_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'data_pedido' => 'Data Pedido',
            'cliente_id' => 'Cliente',
            'valor_total' => 'Total do Pedido',
            'data_retirada' => 'Data Retirada',
            'status' => 'Status',
            'supermercado_id' => 'Loja',
        ];
    }

    public function getCliente()
    {
        return $this->hasOne(User::className(), ['id' => 'cliente_id']);
    }

    public function getSupermercado()
    {
        return $this->hasOne(Supermercado::className(), ['id' => 'supermercado_id']);
    }

    public function getPedidoHasProdutos()
    {
        return $this->hasMany(PedidoHasProduto::className(), ['pedido_id' => 'id']);
    }
}
