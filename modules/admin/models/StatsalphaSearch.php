<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Statsalpha;

/**
 * StatsalphaSearch represents the model behind the search form about `app\modules\admin\models\Statsalpha`.
 */
class StatsalphaSearch extends Statsalpha
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['date', 'textplain', 'stat_id', 'details', 'url', 'channel', 'time', 'what', 'extra', 'status', 'switch_count', 'type', 'mac', 'ip', 'send_date'], 'safe'],
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
        $query = Statsalpha::find();

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
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'textplain', $this->textplain])
            ->andFilterWhere(['like', 'stat_id', $this->stat_id])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'what', $this->what])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'switch_count', $this->switch_count])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'mac', $this->mac])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'send_date', $this->send_date]);

        return $dataProvider;
    }
}
