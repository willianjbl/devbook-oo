<?php

require 'config/config.php';

\Devbook\models\Session::destroy();
\Devbook\functions\Common::redirect();
