<?php

// SiteUtil::require('model/entity/Recipe.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('util/FormatUtil.php');
SiteUtil::require('controller/BaseController.php');




class ArticleController extends BaseEntityController
{

    protected static $entityClass = "Article";
    protected static $dao = "ArticleDao";
    protected static $loggedInUser;
    protected static $entity;
    // public static function getEntityClass()
    // {

    //     return "Users";
    // }

    // public static function callActionMethod($action)
    // {
    //     self::$entity = self::getUser();
    //     if (self::$entity == null) {
    //         $action = "login";
    //     }
    //     parent::callActionMethod($action);
    // }

    public static function callActionMethod($action)
    {
        if (!UserController::getLoggedInUser()->isAdministrator()) {
            $action = "accessDenied";
        }
        parent::callActionMethod($action);
    }
    public static function orders()
    {
        self::render("orders", [
            'entities' => OrdersDao::findAll()
        ]);
    }
    public static function import()
    {
        if (isset($_FILES)) {
            $templateVars = [];
            $templateName = 'edit';

            $tmpName = $_FILES['csvfile']['tmp_name'];
            $filetype = array('csv');
            echo $tmpName . '<br>';
            $name = explode('.', $_FILES['csvfile']['name']);
            $file_ext = strtolower(end($name));
            // $file_ext =  pathinfo($tmpName, PATHINFO_EXTENSION);

            echo $file_ext;
            if (in_array(strtolower($file_ext), $filetype)) {
                $csvAsArray = array_map('str_getcsv', file($tmpName));
                $finaleValue = [];
                foreach ($csvAsArray as $key => $value) {

                    if ($key != 0) {
                        $product = ProductDao::findOneBy('name', $value[7]);
                        $unit = UnitDao::findOneBy('name', $value[8]);
                        $article = ArticleDao::findById($value[3]);
                        $lotValues = [$value[3], $value[2]];
                        $lot = LotDao::findOneLot($lotValues);
                        if (!$product) {
                            $product = new Unit();
                            $product->setName($value[7]);
                            ProductDao::save($product);
                            echo 'no';
                        }
                        if (!$unit) {
                            $unit = new Unit();
                            $unit->setName($value[8]);
                            UnitDao::save($unit);
                            echo 'no unit';
                        }
                        $today = date("Y-m-d H:i:s");
                        if ($article) {
                            $article->setDateModification($today);
                            echo 'yes article';
                            ArticleDao::update($article);
                        } else {
                            $article = new Article();
                            $article->setIdArticle($value[3]);
                            $article->setFlag($value[6]);
                            $article->setDateModification($today);
                            $article->setUnitQuantity($value[4]);
                            $article->setDateCreation($value[5]);
                            $article->setIdProduct($product->getId());
                            $article->setIdUnit($unit->getId());

                            ArticleDao::save($article);
                        }
                        // FormatUtil::dump($article);
                        if ($lot) {
                            echo 'yes article';
                        } else {
                            $lot = new Lot();
                            $lot->setIdArticle($article->getId());
                            $lot->setIdSupplierOrder($value[2]);
                            $lot->setUnitCost($value[9]);
                            $lot->setQuantity($value[0]);
                            $lot->setDateReception($value[1]);
                            // FormatUtil::dump($lot);
                            LotDao::save($lot);
                            $importation = new Importation();
                            $importation->setIdSupplierOrder($lot->getIdSupplierOrder());
                            $importation->setIdArticle($lot->getIdArticle());
                            $importation->setIdAdministrator(UserController::getLoggedInUser()->getId());
                            $importation->setImportationDate($today);
                            ImportationDao::save($importation);
                            $finaleValue[$key]['name'] = $value[4] . ' ' . $unit->getName() . ' de ' . $product->getName();
                            $finaleValue[$key]['amount'] = $lot->getQuantity();
                            $finaleValue[$key]['id'] = $article->getId();
                            $articlePrice = new ArticlePrice();
                            $articlePrice->setPrice($value[10]);
                            $articlePrice->setIdArticle($article->getId());
                            $articlePrice->setDateStart($today);
                            ArticlePriceDao::save($articlePrice);
                        }


                        FormatUtil::dump($value);
                    }
                }

                $templateVars['imported'] = $finaleValue;
                // FormatUtil::dump($csvAsArray);
            } else {
                $templateVars['message'] = 'errorLogin';
            }

            return $templateVars;
            FormatUtil::dump($templateVars);
        }
    }
    public static function edit()
    {


        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            FormatUtil::dump($_POST[static::getEntityClass()]);

            $article = ArticleDao::findById($_POST[static::getEntityClass()]['idArticle']);
            FormatUtil::dump($article);
            $article->setName($_POST[static::getEntityClass()]['name']);
            FormatUtil::dump($article);


            self::getDao()::saveOrUpdate($article);
            // header('Location: ' . SiteUtil::url() . 'recipe/list/'.$recipe->getId());
            // exit;

        }
        if (isset($_FILES['csvfile'])) {
            $templateVars = static::import();
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }



    // SELECT ol.amountReceive, ol.deliveryDate, ol.idOrders ,ol.idArticle , a.amount, a.createdAt,a.articleState, p.productName, c.conditioningName , s.price FROM order_line ol INNER JOIN article a ON ol.idArticle=a.idArticle INNER JOIN product p ON a.idProduct = p.idProduct INNER JOIN conditioning c ON a.idArticle = c.idConditioning INNER JOIN orders o ON ol.idOrders = o.idOrders INNER JOIN sell s ON o.idProvider = s.idProvider AND a.idArticle = s.idArticle WHERE ol.deliveryDate IS NOT NULL

    // SELECT ol.amountReceive, ol.deliveryDate, ol.idOrders ,ol.idArticle , a.amount, a.createdAt,a.articleState, p.productName, c.conditioningName FROM order_line ol INNER JOIN article a ON ol.idArticle=a.idArticle INNER JOIN product p ON a.idProduct = p.idProduct INNER JOIN conditioning c ON a.idArticle = c.idConditioning WHERE ol.deliveryDate IS NOT NULL
    // SELECT ol.amountReceive, ol.deliveryDate, ol.idOrders ,ol.idArticle , a.amount, a.createdAt,a.articleState, p.productName, c.conditioningName , s.price, MAX(s2.price) FROM order_line ol INNER JOIN article a ON ol.idArticle=a.idArticle INNER JOIN product p ON a.idProduct = p.idProduct INNER JOIN conditioning c ON a.idConditioning = c.idConditioning INNER JOIN orders o ON ol.idOrders = o.idOrders INNER JOIN sell s ON o.idProvider = s.idProvider AND a.idArticle = s.idArticle INNER JOIN sell s2 ON a.idArticle=s2.idArticle  WHERE ol.deliveryDate IS NOT NULL GROUP BY ol.idOrders, ol.idArticle

}
