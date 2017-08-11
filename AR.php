<?php
namespace app\packages\Crud;

use yii;
use yii\db\Query;

//demo
//Yii::$container->setSingleton('ProviderStatusModel', 'app\packages\Crud\AR', [new ProviderStatus()]);

class AR
{
    public $ArModel;
    public $db;
    public $tableName;

    public function __construct($ArModel)
    {
        $this->ArModel = $ArModel;
        $this->db = $ArModel::getDb();
        $this->tableName = $ArModel::tableName();
    }

    /**
     * 获取ArModel类内部常量
     * @param string $name
     * @return mixed
     */
    public function getConstant($name = '')
    {
        return (new \ReflectionClass($this->ArModel))->getConstant($name);
    }

    /**
     * 批量获取记录
     * @param string $fields
     * @param array $condition
     * @param int $offset
     * @param int $limit
     * @param string $orderBy
     * @param string $groupBy
     * @return mixed
     */
    public function getList($fields = '*', $condition = [], $offset = 0, $limit = 20, $orderBy = '', $groupBy = '')
    {
        $model = $this->ArModel->find()->select($fields);
        $model->where($condition);
        if (!empty($orderBy))
        {
            $model->orderBy($orderBy);
        }
        if (!empty($groupBy))
        {
            $model->groupBy($groupBy);
        }
        if (!empty($limit))
        {
            $model->offset($offset)->limit($limit);
        }
        return $model->asArray()->all();
    }

    /**
     * 获取单条记录
     * @param string $fields
     * @param array $condition
     * @param string $orderBy
     * @param string $groupBy
     * @return mixed
     */
    public function getInfo($fields = '*', $condition = [], $orderBy = '', $groupBy = '')
    {
        $model = $this->ArModel->find()->select($fields);
        $model->where($condition);

        if (!empty($orderBy))
        {
            $model->orderBy($orderBy);
        }

        if (!empty($groupBy))
        {
            $model->groupBy($groupBy);
        }
        return $model->asArray()->one();
    }

    /**
     * 获取记录总数
     * @param string $fields
     * @param $condition
     */
    public function getCount($fields = '*', $condition = [])
    {
        $model = $this->ArModel->find()->select($fields);
        $model->where($condition);
        return $model->count();
    }

    /**
     * 插入单条记录
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        $this->ArModel = new $this->ArModel();
        $this->ArModel->setAttributes($data);
        if ($this->ArModel->insert())
        {
            return $this->db->getLastInsertID();
        }
        else if (!empty($this->ArModel->errors))
        {
            return $this->ArModel->getErrors();
        }
        return false;
    }

    /**
     * 插入多条记录（不进行AR模型字段校验）
     * @param $files
     * @param $data
     * @return mixed
     */
    public function insertOne($data)
    {
        $num = $this->db->createCommand()->insert(
            $this->tableName,
            $data
        )->execute();
        if(is_numeric($num)){
            return $this->db->getLastInsertID();
        }
        return false;
    }

    /**
     * 插入多条记录
     * @param $files
     * @param $data
     * @return mixed
     */
    public function insertMany($files,$data)
    {
        $num = $this->db->createCommand()->batchInsert(
            $this->tableName,
            $files,
            $data
        )->execute();
        if(is_numeric($num)){
            return $num;
        }
        return false;
    }

    /**
     * 更新单条记录
     * @param $data
     * @param $condition
     * @return mixed
     */
    public function updateOne($data, $condition)
    {
        $model = $this->ArModel->find()->where($condition)->one();
        if (empty($model))
        {
            return 0;
        }
        foreach ($data as $fields => $val)
        {
            $model->{$fields} = $val;
        }
        if ($model->save())
        {
            return true;
        }
        else if (!empty($model->errors))
        {
            return $model->getErrors();
        }
        return false;
    }

    /**
     * 批量更新数据（不进行AR模型字段校验）
     * @param $data
     * @param $condition
     * @param array $params
     * @return mixed
     */
    public function updateAll($data, $condition, $params = [])
    {
        return $this->ArModel->updateAll($data, $condition, $params);
    }

    /**
     * 删除单条数据
     * @param $condition
     * @param array $params
     * @return bool
     */
    public function deleteOne($condition, $params = [])
    {
        $model = $this->ArModel->find()->where($condition, $params)->one();
        if (empty($model))
        {
            return 0;
        }
        if ($model)
        {
            return $model->delete();
        }
        return false;
    }

    /**
     * 批量删除数据
     * @param $condition
     * @param $params
     */
    public function deleteAll($condition, $params = [])
    {
        return $this->ArModel->deleteAll($condition, $params);
    }

    /**
     * 获取某字段的和
     * @param $field_name
     * @param array $condition
     * @param array $params
     * @return int
     */
    public function getFieldSum($field_name, $condition = [], $params = [])
    {
        if (empty($field_name))
        {
            return false;
        }

        return $this->ArModel->find()->select('sum(' . $field_name . ')')->where($condition, $params)->scalar();
    }

    /**
     * 关联模型查询（需要在主model中定义关联模式）
     * @param string $fields
     * @param array $joinArray
     * @param array $where
     * @param array $andWhere
     * @param string $orderBy
     * @param int $page
     * @param int $limit
     * @param bool $noDist
     * @param string $countFields
     * @param string $groupBy
     * @return obj or array
     */
    public function getRelationList(
        $fields = '*',
        $joinArray = [],
        $where = [],
        $andWhere = [],
        $orderBy = '',
        $page = 1,
        $limit = 20,
        $noDist = false,
        $countFields = '*',
        $groupBy = ''
    ) {
        if ($noDist)
        {
            $obj = $this->ArModel->find()->select($fields);
            $countObj = $this->ArModel->find()->select($countFields);
        }
        else
        {
            $obj = $this->ArModel->find()->select($fields)->distinct();
            $countObj = $this->ArModel->find()->select($countFields)->distinct();
        }

        if (!empty($where))
        {
            if (isset($where['sql']) || isset($where['params']))
            {
                $obj->where($where['sql'], $where['params']);
                $countObj->where($where['sql'], $where['params']);
            }
            else if (is_array($where))
            {
                $obj->where($where);
                $countObj->where($where);
            }
        }

        if (!empty($andWhere))
        {
            $obj = $obj->andWhere($andWhere);
            $countObj = $countObj->andWhere($andWhere);
        }

        foreach ($joinArray as $model_name => $join)
        {
            if (in_array($join, ['with', 'joinWith']))
            {
                $obj = $obj->$join($model_name);
                $countObj = $countObj->$join($model_name);
            }
        }

        if (!empty($groupBy))
        {
            $obj = $obj->groupBy($groupBy);
            $countObj = $countObj->groupBy($groupBy);
        }

        if (!empty($orderBy))
        {
            $obj = $obj->orderBy($orderBy);
        }

        if (!empty($page) && $limit > 0)
        {
            $offset = ($page - 1) * $limit;
            $obj = $obj->offset($offset)->limit($limit);
        }

        $data = $obj->asArray()->all();

        $count = $countObj->count();
        return ['items' => $data, 'count' => $count];
    }

    /**
     * 关联模型查询（需要在主model中定义关联模式）
     * @param string $fields
     * @param $joinArray
     * @param array $where
     * @param array $andWhere
     * @return array|yii\db\ActiveRecord[]
     */
    public function getRelationInfo($fields = '*', $joinArray = [], $where = [], $andWhere = [])
    {
        $obj = $this->ArModel->find()->select($fields);

        if (!empty($where))
        {
            $obj = $obj->where($where);
        }

        if (!empty($andWhere))
        {
            $obj = $obj->andWhere($andWhere);
        }

        if (!empty($joinArray))
        {
            foreach ($joinArray as $model_name => $type)
            {
                if (!in_array($type, ['with', 'joinWith']))
                {
                    continue;
                }
                $obj = $obj->$type($model_name);
            }
        }

        $data = $obj->asArray()->one();

        return $data;
    }

    /**
     * 关联模型查询（需要在主model中定义关联模式）
     * @param string $fields
     * @param $joinArray
     * @param array $where
     * @param array $andWhere
     * @return array|yii\db\ActiveRecord[]
     */
    public function getRelationCount($fields = '*', $joinArray = [], $where = [], $andWhere = [])
    {
        $obj = $this->ArModel->find()->select($fields);

        if (!empty($where))
        {
            $obj = $obj->where($where);
        }

        if (!empty($andWhere))
        {
            $obj = $obj->andWhere($andWhere);
        }

        if (!empty($joinArray))
        {
            foreach ($joinArray as $model_name => $type)
            {
                if (!in_array($type, ['with', 'joinWith']))
                {
                    continue;
                }
                $obj = $obj->$type($model_name);
            }
        }

        return $obj->count();

    }

    /*
     * 通过生成器单表查询
     */
    public function eachQuery($fields = '*',$where=[],$offset=0,$limit=0,$orderBy=''){

        $query = (new Query())
                ->select($fields)
                ->from($this->tableName);

        if(!empty($where)){
            $query->where($where);
        }
        if($limit > 0 && $offset >= 0){
            $query->offset($offset);
            $query->limit($limit);
        }
        if($orderBy!=''){
            $query->orderBy($orderBy);
        }

        $res = [];
        foreach ($query->each() as $k=> $v) {
            $res[$k] = $v;
        }
        return $res;
    }

}