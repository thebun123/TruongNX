<?php

namespace TruongNX\Tutorial\Api\Data;

interface FAQStoreInterface{
    const ID = 'id';
    const FAQ_ID = 'faq_id';
    const STORE_ID = 'store_id';

    public function getId();
    public function setId($id);

    public function getFAQ_Id();
    public function setFAQ_Id($fId);

    public function getStore_Id();
    public function setStore_Id($sId);


}
