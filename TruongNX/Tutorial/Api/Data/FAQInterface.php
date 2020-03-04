<?php

namespace TruongNX\Tutorial\Api\Data;

interface FAQInterface
{
    const ID = 'id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const IMAGE = 'image';
    const STATUS = 'status';
    const CREATE_TIME = 'create_time';
    const UPDATE_TIME = 'update_time';

    public function getId();
    public function setId($id);

    public function getTitle();
    public function setTitle($title);

    public function getDes();
    public function setDes($des);

    public function getImage();
    public function setImage($image);

    public function getStatus();
    public function setStatus($status);

    public function getCreateTime();
    public function setCreateTime($time);

    public function getUpdateTime();
    public function setUpdateTime($time);
}
