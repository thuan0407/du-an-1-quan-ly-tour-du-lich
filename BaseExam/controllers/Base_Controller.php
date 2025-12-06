<?php
require_once __DIR__ . '/../models/Address_Model.php';
require_once __DIR__ . '/../models/Book_tour_Model.php';
require_once __DIR__ . '/../models/Contract_Model.php';
require_once __DIR__ . '/../models/Customer_list_Model.php';
require_once __DIR__ . '/../models/Departure_schedule_Model.php';
require_once __DIR__ . '/../models/Img_tour_Model.php';
require_once __DIR__ . '/../models/Pay_Model.php';
require_once __DIR__ . '/../models/Policy_Model.php';
require_once __DIR__ . '/../models/Roll_call_Model.php';
require_once __DIR__ . '/../models/Special_request_Model.php';
require_once __DIR__ . '/../models/Supplier_Model.php';
require_once __DIR__ . '/../models/Tour_diary_Model.php';
require_once __DIR__ . '/../models/Tour_guide_Model.php';
require_once __DIR__ . '/../models/Tour_Model.php';
require_once __DIR__ . '/../models/Tour_supplier_Model.php';
require_once __DIR__ . '/../models/Tour_type_Model.php';
require_once __DIR__ . '/../models/User_Model.php';
require_once __DIR__ . '/../models/Departure_schedule_details.php';
require_once __DIR__ . '/../models/Schedule_details_Model.php';



class Base_Controller 
{
    public $addressModel;
    public $booktourModel;
    public $contractModel;
    public $customerlistModel;
    public $departurescheduleModel;
    public $imgtourModel;
    public $payModel;
    public $policyModel;
    public $rollcallModel;
    public $specialrequestModel;
    public $supplierModel;
    public $tourdiaryModel;
    public $tourguideModel;
    public $tourModel;
    public $toursupplierModel;
    public $tourtypeModel;
    public $userModel;
    public $departurescheduledetailsModel;
    public $scheduledetailsModel;

    public function __construct() {
        $this->addressModel            = new Address_Model();
        $this->booktourModel           = new Book_tour_Model();
        $this->contractModel           = new Contract_Model();
        $this->customerlistModel       = new Customer_list_Model();
        $this->departurescheduleModel  = new Departure_schedule_Model();
        $this->imgtourModel            = new Img_tour_Model();
        $this->payModel                = new Pay_Model();
        $this->policyModel             = new Policy_Model();
        $this->rollcallModel           = new Roll_call_Model();
        $this->specialrequestModel     = new Special_request_Model();
        $this->supplierModel           = new Supplier_Model();
        $this->tourdiaryModel          = new Tour_diary_Model();
        $this->tourguideModel          = new Tour_guide_Model();
        $this->tourModel               = new Tour_Model();
        $this->toursupplierModel       = new Tour_supplier_Model();
        $this->tourtypeModel           = new Tour_type_Model();
        $this->userModel               = new User_Model();
        $this->departurescheduledetailsModel  = new Departure_schedule_details_Model();
        $this->scheduledetailsModel    = new Schedule_details_Model();
    }

}