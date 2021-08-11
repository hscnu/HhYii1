<?php

class FishingGoodsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    function saveData($model, $post) {
        $model->attributes = $post;
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //列表搜索
    public function actionIndex($keywords = '', $fType = '',$oper='') {

        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','f_code,f_name,f_group,f_type,f_type_CN',$keywords);
        if ($fType != null){
            $criteria->addCondition("f_type = :f_type");
            $criteria->params[':f_type']=$fType;
        }
        $criteria->order="f_type_CN,f_name"
        ;        $data = array();
        $data['xls'] ="";
        if ($oper=='excel'){
            $data1=$model->findALL( $criteria);
            $this->actionSavetoexcel($data1);
            $data['xls'] = $this->save_excel_file(1);
        }

        parent::_list($model, $criteria, 'index', $data);
    }


    public function actionSavetoexcel($data) {
        $texcel = new PHPExcel();
        $texcel->setActiveSheetIndex(0);
        //报表头的输出
        $texcel->getActiveSheet()->mergeCells('B1:G1');
        $texcel->getActiveSheet()->setCellValue('B1','登記表');

        $texcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setSize(24);
        $texcel->setActiveSheetIndex(0)->getStyle('B1')
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $texcel->setActiveSheetIndex(0)->setCellValue('B2','日期：'.date("Y年m月j日"));
        $texcel->setActiveSheetIndex(0)->setCellValue('G2','第'.'頁');
        $texcel->setActiveSheetIndex(0)->getStyle('G2')
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        //表格頭的輸出
        $texcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $texcel->setActiveSheetIndex(0)->setCellValue('B3','编码');
        $texcel->getActiveSheet()->getColumnDimension('B')->setWidth(6.5);
        $texcel->setActiveSheetIndex(0)->setCellValue('C3','名称');
        $texcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $texcel->setActiveSheetIndex(0)->setCellValue('D3','组别');
        $texcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $texcel->setActiveSheetIndex(0)->setCellValue('E3','类型');
        $texcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $texcel->setActiveSheetIndex(0)->setCellValue('F3','序号');
        $texcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $texcel->setActiveSheetIndex(0)->setCellValue('G3','活名称');
        $texcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $page_size = 52;

        $n = 4;

        foreach ( $data as $v ){

            $texcel->getActiveSheet()->setCellValue('B'.($n) ,$v->f_code);
            $texcel->getActiveSheet()->setCellValue('C'.($n) ,$v->f_name);
            $texcel->getActiveSheet()->setCellValue('D'.($n) ,$v->f_group);
            $texcel->getActiveSheet()->setCellValue('E'.($n) ,$v->f_type);
            $texcel->getActiveSheet()->setCellValue('F'.($n) ,$v->f_order);
            $texcel->getActiveSheet()->setCellValue('G'.($n) ,$v->f_type_CN);
            $n+=1;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($texcel,'Excel5');
        $objWriter->save($this->save_excel_file(1));
    }


    function save_excel_file($dtype=0){
        return (($dtype) ? getWwwPath():getLocalPath()).'基本数据.xls';
    }



}
