<?php

namespace App\Admin\Controllers;

use App\Models\Articles;
use App\Http\Controllers\Controller;
use App\Models\Topics;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ArticleController extends Controller
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
        $grid = new Grid(new Articles);

        $grid->id('Id');
        $grid->name('姓名');
        $grid->topics()->name('分类');
        $grid->user()->name('用户');
        $grid->status('Status');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->comment_count('Comment count');

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
        $show = new Show(Articles::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->topics_id('Topics id');
        $show->user_id('User id');
        $show->status('Status');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->comment_count('Comment count');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Articles);

        $form->text('name', 'Name');
        $form->select('topics_id', '分类')->options (Topics::getSelectName());
        $form->select('user_id', '用户')->options (User::getSelectUser());
        $form->number('status', 'Status')->default(1);
        $form->number('comment_count', 'Comment count');
        return $form;
    }
}
