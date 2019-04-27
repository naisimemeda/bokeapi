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
        $grid->id('Id');
        $grid->name('姓名');
        $grid->status('Status');
        $grid->is_admin('管理员')->display(function ($is_admin){
            return $is_admin === 1 ? '是' : '否';
        });
        $grid->phone('电话');
        $grid->email('邮箱');
        $grid->avatar('头像')->display(function ($avatar){
            return $avatar ? "<img width='50px' height='50px' src='$avatar'>" : '';
        });
        $grid->notice_count('通知数量');
        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');
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

        $show->id('Id');
        $show->name('Name');
        $show->password('Password');
        $show->status('Status');
        $show->is_admin('Is admin');
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
        $form->password('password', 'Password');
        $form->number('status', 'Status');
        $form->number('is_admin', 'Is admin');
        $form->mobile('phone', 'Phone');
        $form->email('email', 'Email');
        $form->image('avatar', 'Avatar');
        $form->number('notice_count', 'Notice count');
        return $form;
    }
}
