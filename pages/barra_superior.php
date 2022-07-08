        <!-- Navigation -->
        
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Portal de proveedores - <?php echo utf8_encode($_SESSION['CardName']);?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['User'];?> <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu dropdown-user">
                       <!-- <li><a href="datos_proveedor.php"><i class="fa fa-user fa-fw"></i> Datos del proveedor</a>
                        </li>-->
                        <li><a href="cambiar_clave_portal.php"><i class="fa fa-key fa-fw"></i> Cambiar contrase&ntilde;a</a>
                        </li>
                        <li><a href="ayuda.php"><i class="fa fa-bell faa-ring fa-fw"></i> Ayuda</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>