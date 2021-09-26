<?php


class Parcel
{
    const BY_WEIGHT = 1;
    const BY_VOLUME = 2;
    const BY_VALUE = 3;


    private $item_name;
    private $weight;
    private $volume;
    private $declared_value;
    private $chosen_model = 1;

    public function toJSON(){
        return array(
            'item_name' => $this->getItemName(),
            'weight' => $this->getWeight(),
            'volume' => $this->getVolume(),
            'declared_value' => $this->getDeclaredValue(),
            'chosen_model' => $this->getChosenModel(),
        );
    }

    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * @param mixed $item_name
     */
    public function setItemName($item_name)
    {
        $this->item_name = $item_name;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    /**
     * @return mixed
     */
    public function getDeclaredValue()
    {
        return $this->declared_value;
    }

    /**
     * @param mixed $declared_value
     */
    public function setDeclaredValue($declared_value)
    {
        $this->declared_value = $declared_value;
    }

    /**
     * @return mixed
     */
    public function getChosenModel()
    {
        return $this->chosen_model;
    }

    /**
     * @param mixed $chosen_model
     */
    public function setChosenModel($chosen_model)
    {
        $this->chosen_model = $chosen_model;
    }


}