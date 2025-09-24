<?php
namespace Modules\Course\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Space\Models\Space;
use Modules\Space\Models\SpaceDate;

class AvailabilityController extends \Modules\Course\Controllers\AvailabilityController
{
    protected $spaceClass;
    /**
     * @var SpaceDate
     */
    protected $spaceDateClass;
    protected $indexView = 'Course::admin.availability';

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/course');
        $this->middleware('dashboard');
    }

}
