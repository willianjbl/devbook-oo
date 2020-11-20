<?php

require 'config/config.php';

\Devbook\models\Session::destroy();
\Devbook\utility\Common::redirect();
