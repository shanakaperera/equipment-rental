<?php

namespace Modules\User\DataTables\TableView;

use Carbon\Carbon;
use Modules\User\Entities\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields\Text;
use Yajra\DataTables\Html\Editor\Fields\TextArea;

class RoleDataTable extends DataTable
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
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Modules\User\Entities\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return auth()->user()->hasRole('developer') ? $model->newQuery() : $model->newQuery()->where('name', '<>', 'developer');
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
            ->setTableId('role-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(3, 'ASC')
            ->select('single')
            ->responsive()
            ->pageLength(20)
            ->buttons(
                Button::make('create')->editor('editor')->authorized(user()->isAbleTo('create-user-role')),
                Button::make('edit')->text('Edit')->authorized(user()->isAbleTo('update-user-role'))
                    ->action('function(e, dt, node, config) { let url = \'' . route('admin.roles.edit', ':id') . '\'; url = url.replace(\':id\', dt.rows({selected:true}).ids()[0]); window.location.href = url; }'),
                Button::make('remove')->editor('editor')->authorized(user()->isAbleTo('delete-user-role')),
                Button::make('')->text('<i class="fas fa-sync-alt"></i>  Reload')->action('function(e, dt, node, config){ dt.draw(false); }')
            )->editor(
                Editor::make()->fields([
                    Text::make('name'),
                    Text::make('display_name'),
                    TextArea::make('description'),
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
            Column::make('name'),
            Column::make('display_name'),
            Column::make('description'),
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
        return 'Role_' . date('YmdHis');
    }
}
