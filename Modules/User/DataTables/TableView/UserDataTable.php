<?php

namespace Modules\User\DataTables\TableView;

use Illuminate\Support\Carbon;
use Modules\User\Entities\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields\Text;
use Yajra\DataTables\Html\Editor\Fields\Password;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->setRowId('id')
            ->editColumn('status', function ($data) {
                return $data->status ? 'Active' : 'Deactivated';
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d');
            });
    }


    /**
     * Get query source of dataTable.
     *
     * @param \Modules\User\Entities\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return auth()->user()->hasRole('developer') ?
            $model->newQuery() :
            $model->newQuery()->WhereDoesntHave('roles', function ($q) {
                $q->where('name', '=', 'developer');
            });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     * @throws \Exception
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'ASC')
            ->select('single')
            ->responsive()
            ->pageLength(20)
            ->buttons(
                Button::make('create')->editor('editor')->authorized(user()->isAbleTo('create-user')),
                Button::make('edit')->text('Edit')->authorized(user()->isAbleTo('update-user'))
                    ->action('function(e, dt, node, config) { let url = \'' . route('admin.users.edit', ':id') . '\'; url = url.replace(\':id\', dt.rows({selected:true}).ids()[0]); window.location.href = url; }'),
                Button::make('remove')->editor('editor')->authorized(user()->isAbleTo('delete-user')),
                Button::make('')->text('<i class="fas fa-sync-alt"></i>  Reload')->action('function(e, dt, node, config){ dt.draw(false); }'),
                Button::make('edit')->editor('editor')->text('<i class="fas fa-lock-keyhole"></i>  Password Change')
                    ->authorized(user()->isAbleTo('update-user-credentials'))
            )->editor(
                Editor::make()->fields([
                    Text::make('first_name'),
                    Text::make('last_name'),
                    Text::make('email'),
                    Password::make('password'),
                    Password::make('password_confirmation')->label('Confirm Password'),
                ])
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('code'),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('email'),
            Column::make('status'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
