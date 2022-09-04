<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $email
 * @property string $phone
 * @property string|null $text
 * @property int|null $manager_id
 *
 * @property Manager|null $manager
 */
class Request extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'requests';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function rules()
    {
        return [
            [['email', 'phone'], 'required'],
            ['email', 'email'],
            ['manager_id', 'integer'],
            ['manager_id', 'exist', 'targetClass' => Manager::class, 'targetAttribute' => 'id'],
            [['email', 'phone'], 'string', 'max' => 255],
            ['text', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Добавлен',
            'updated_at' => 'Изменен',
            'email' => 'Email',
            'phone' => 'Номер телефона',
            'manager_id' => 'Ответственный менеджер',
            'text' => 'Текст заявки',
        ];
    }

    public function getManager()
    {
        return $this->hasOne(Manager::class, ['id' => 'manager_id']);
    }

    public function getLastRequest()
    {
        $date = new \DateTime('-30 days');
        $date = $date->format('Y-m-d H:i:s');

        $request = Request::find()
            ->where(['phone' => $this->phone])
            ->orWhere(['email' => $this->email])
            ->andWhere(['>=', 'created_at', $date])
            ->andWhere(['!=', 'id', $this->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        return $request ?? null;
    }

    public function getAutoManager($managerId = null)
    {
        if(empty($managerId)) {
            $manager = Manager::find()
                ->where(['is_works' => true])
                ->orderBy(['counter' => SORT_ASC])
                ->one();
        }else{
            $manager = Manager::findOne($managerId);
        }

        $counter = $manager->counter + 1;
        $manager->setAttribute('counter', $counter);
        $manager->save();

        return $manager->id;
    }

    public function beforeSave($insert)
    {
        if (!$this->manager_id) {
            $lastRequest = $this->getLastRequest();
            if($lastRequest){
                $manager = Manager::findOne($lastRequest->manager_id);
                if($manager && $manager->is_works){
                    $this->manager_id = $this->getAutoManager($lastRequest->manager_id);
                }else{
                    $this->manager_id = $this->getAutoManager();
                }
            }else{
                $this->manager_id = $this->getAutoManager();
            }
        }
        return parent::beforeSave($insert);
    }
}
