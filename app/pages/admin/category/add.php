<?php
session_start();

include '../../../services/connection.php';
include '../../../services/categoryService.php';
$categoryService = new CategoryService($conn);
$categories = $categoryService::menus($categoryService->allIncludedInactive());

include '../../../services/userService.php';
include '../../../constants.php';
$userService = new UserService($conn);
if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");

if (!$userService->isAuthorize('Quản lý danh mục'))
    header("Location: ../../authentication/login.php");

include '../templates/head.php';
include '../templates/navigation.php';
include '../templates/sidebar.php';

?>

    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="#">Trang quản trị</a>
                    </li>
                    <li class="active">Thêm danh mục</li>
                </ul><!-- /.breadcrumb -->

                <div class="nav-search" id="nav-search">
                    <form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input"
                                           id="nav-search-input" autocomplete="off"/>
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
                    </form>
                </div><!-- /.nav-search -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        Quản lý danh mục
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            Thêm danh mục
                        </small>
                    </h1>
                </div><!-- /.page-header -->

                <!--page content-->
                <div class="row">
                    <div class="col-md-6">
                        <form action="" class="form-horizontal frm-add-category">
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Tên danh mục</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="category_name" autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Kích hoạt</label>
                                <div class="col-md-9">
                                    <label style="margin-top: 10px">
                                        <input name="switch-field-1" class="ace ace-switch" type="checkbox"
                                               id="category_is_active"/>
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Danh mục cha</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="category_parent">
                                        <option>Chọn danh mục cha</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="button" class="btn btn-primary btn-xs js-save-new-category">
                                        <i class="fa fa-plus"></i>
                                        Thêm mới
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div><!-- /.page-content -->
        </div>
    </div>

<?php
include '../templates/footer.php';
?>

    <script src="/sports-shop-final/assets/admin/js/services/categoryService.js"></script>
    <script src="/sports-shop-final/assets/admin/js/controllers/categoryController.js"></script>

<?php if (isset($_SESSION["flashMessage"])): ?>
    <script>
        utilities.notify("Thông báo", '<?php echo $_SESSION["flashMessage"];?>', "gritter-success");
    </script>
    <?php unset($_SESSION["flashMessage"]); ?>
<?php endif; ?>

<?php
include '../templates/bottom.php';
?>