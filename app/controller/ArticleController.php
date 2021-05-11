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

    
    public static function callActionMethod($action)
    {
        if (!UserController::getLoggedInUser()->isAdministrator()) {
            $action = "accessDenied";
        }
        parent::callActionMethod($action);
    }
    // this function get all orders 
    public static function orders()
    {
        self::render("orders", [
            'entities' => OrdersDao::findAll()
        ]);
    }

    // function to import new article with csv file 
    public static function import()
    {
        if (isset($_FILES)) {
            $templateVars = [];
            $templateName = 'edit';

            $tmpName = $_FILES['csvfile']['tmp_name']; // get the temporary file name 
            $filetype = array('csv'); // the authorized file type
            $name = explode('.', $_FILES['csvfile']['name']);
            $file_ext = strtolower(end($name));
            // if the file upload have the allowed type
            if (in_array(strtolower($file_ext), $filetype)) {
                $csvAsArray = array_map('str_getcsv', file($tmpName)); // create an array with the csv content
                $finaleValue = [];

                // loop on the csv array 
                foreach ($csvAsArray as $key => $value) {

                    // the firt line of our file is th title and we don't need look it
                    if ($key != 0) {
                        $product = ProductDao::findOneBy('name', $value[7]);
                        $unit = UnitDao::findOneBy('name', $value[8]);
                        $article = ArticleDao::findById($value[3]);
                        $lotValues = [$value[3], $value[2]];
                        $lot = LotDao::findOneLot($lotValues);

                        // check if the product imported is already exist or not if not we create it
                        if (!$product) {
                            $product = new Product();
                            $product->setName($value[7]);
                            ProductDao::save($product);
                            if ($value[11] == 'ingredient') {
                                $product->makeIngredient();
                            }
                        }
                        // check if the unit imported is already exist or not if not we create it
                        if (!$unit) {
                            $unit = new Unit();
                            $unit->setName($value[8]);
                            UnitDao::save($unit);
                        }
                        $today = date("Y-m-d H:i:s");
                        // if the article is already exist update the modification date to the current day
                        if ($article) {
                            $article->setDateModification($today);
                            ArticleDao::update($article);
                        } else {
                            // if the article is not exist is created 
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
                        // if the lot not exist we create a new lot add the importation and the new price and create a result to display
                        if (!$lot) {

                            $lot = new Lot();
                            $lot->setIdArticle($value[3]);
                            $lot->setIdSupplierOrder($value[2]);
                            $lot->setUnitCost($value[9]);
                            $lot->setQuantity($value[0]);
                            $lot->setDateReception($value[1]);
                            LotDao::save($lot);
                            //the importation
                            $importation = new Importation();
                            $importation->setIdSupplierOrder($lot->getIdSupplierOrder());
                            $importation->setIdArticle($lot->getIdArticle());
                            $importation->setIdAdministrator(UserController::getLoggedInUser()->getId());
                            $importation->setImportationDate($today);
                            ImportationDao::save($importation);
                            // the result to display
                            $finaleValue[$key]['name'] = $value[4] . ' ' . $unit->getName() . ' de ' . $product->getName();
                            $finaleValue[$key]['amount'] = $lot->getQuantity();
                            $finaleValue[$key]['id'] = $article->getId();

                            // the new price 
                            $articlePrice = new ArticlePrice();
                            $articlePrice->setPrice($value[10]);
                            $articlePrice->setIdArticle($value[3]);
                            $articlePrice->setDateStart($today);
                            ArticlePriceDao::save($articlePrice);
                        }


                    }
                }

                $templateVars['imported'] = $finaleValue;
            } else {
                $templateVars['message'] = 'error';
            }
            return $templateVars;
        }
    }
    // edit the article
    public static function edit()
    {


        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view

            $today = date("Y-m-d H:i:s");
            // $article = ArticleDao::findById($_POST[static::getEntityClass()]['idArticle']);
            $article = static::getEntity();
            $article->setName($_POST[static::getEntityClass()]['name']);
            $article->setFlag($_POST[static::getEntityClass()]['flag']);
            $article->setDateModification($today);

            self::getDao()::saveOrUpdate($article);

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
    //     SELECT
    //     ol.amountReceive,
    //     ol.deliveryDate,
    //     ol.idOrders,
    //     ol.idArticle,
    //     a.amount,
    //     a.createdAt,
    //     a.articleState,
    //     p.productName,
    //     c.conditioningName,
    //     s.price,
    //     igr.idProduct,
    //     MAX(s2.price * 1.2),
    //     CASE WHEN igr.idProduct IS NULL THEN 'ustensil' ELSE 'ingredient'
    // END
    // FROM
    //     order_line ol
    // INNER JOIN article a ON
    //     ol.idArticle = a.idArticle
    // INNER JOIN product p ON
    //     a.idProduct = p.idProduct
    // INNER JOIN conditioning c ON
    //     a.idConditioning = c.idConditioning
    // INNER JOIN orders o ON
    //     ol.idOrders = o.idOrders
    // INNER JOIN sell s ON
    //     o.idProvider = s.idProvider AND a.idArticle = s.idArticle
    // INNER JOIN sell s2 ON
    //     a.idArticle = s2.idArticle
    // LEFT JOIN ingredient igr ON
    //     p.idProduct = igr.idProduct
    // WHERE
    //     ol.deliveryDate IS NOT NULL AND s2.idProvider IN(
    //     SELECT
    //         p1.idProvider
    //     FROM
    //         provider p1
    //     INNER JOIN orders o1 ON
    //         p1.idProvider = o1.idProvider
    //     INNER JOIN order_line ol1 ON
    //         ol1.idOrders = o1.idOrders
    //     WHERE
    //         ol1.idArticle = a.idArticle
    // )
    // GROUP BY
    //     ol.idOrders,
    //     ol.idArticle
}
