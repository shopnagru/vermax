<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Requests;

/**
 * RequestsSearch represents the model behind the search form about `app\modules\admin\models\Requests`.
 */
class RequestsSearch extends Requests
{

    public $time2 = '';
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['ip', 'mac', 'version', 'fw', 'type', 'response', 'time','time2'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Requests::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,

        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'mac', $this->mac])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'fw', $this->fw])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'response', $this->response])
            ->andFilterWhere(['between', 'time', $this->time, $this->time2]);

        return $dataProvider;
    }
}
