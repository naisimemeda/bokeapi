<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */

    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->id('Id')->sortable();
        $grid->name('姓名');
        $grid->avatar('头像')->image(config('app.url/uploads/'));
        $grid->phone('电话');
        $grid->email('邮箱');
        $grid->is_admin('是否为管理员')->switch([
            '是'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            '否' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ]);
        $grid->status('状态')->using([1 => '是', 0 => '否']);
        $grid->notice_count('通知数量');
        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');
        $grid->filter(function($filter){
            $filter->like('name', 'name');
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));
        $show->name('姓名');
        $show->status('状态');
        $show->is_admin('权限');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->phone('Phone');
        $show->email('Email');
        $show->avatar('Avatar');
        $show->notice_count('Notice count');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);
        $form->text('name', 'Name');
        $form->switch('status', 'Status')->options([ 1 => '是', 0 => '否']);
        $form->switch('is_admin', 'Is admin');
        $form->mobile('phone', 'Phone');
        $form->email('email', 'Email');
        $form->image('avatar', 'Avatar');
        $form->number('notice_count', 'Notice count');
        return $form;
    }
}
