<?php

namespace Modules\User\DataTables\TableView;

use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Modules\User\Entities\Permission;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields\Text;
use Yajra\DataTables\Html\Editor\Fields\Select2;
use Yajra\DataTables\Html\Editor\Fields\TextArea;
use Modules\Core\Contracts\ModuleUtilityContract;

class PermissionDataTable extends DataTable
{

    private $muc;

    /**
     * PermissionDataTable constructor.
     * @param ModuleUtilityContract $muc
     */
    public function __construct(ModuleUtilityContract $muc)
    {
        $this->muc = $muc;
    }


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
            })->editColumn('ltpm', function ($data) {
                return substr(strrchr(rtrim($data->ltpm, '\\'), '\\'), 1);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Modules\User\Entities\Permission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Permission $model)
    {
        return $model->newQuery();
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
            ->setTableId('permission-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy([4, 'asc'])
            ->rowGroup(['dataSrc' => 'ltpm'])
            ->select('single')
            ->pageLength(20)
            ->responsive()
            ->buttons(
                Button::make('create')->editor('editor')->authorized(user()->isAbleTo('create-permission')),
                Button::make('edit')->editor('editor')->authorized(user()->isAbleTo('update-permission')),
                Button::make('remove')->editor('editor')->authorized(user()->isAbleTo('delete-permission')),
                Button::make('')->text('<i class="fas fa-sync-alt"></i>  Reload')->action('function(e, dt, node, config){ dt.draw(false); }')
            )->editor(
                Editor::make()->fields([
                    Text::make('name'),
                    Text::make('display_name'),
                    TextArea::make('description'),
                    Select2::make('ltpm', 'Related Model')->options($this->muc->getAllEntities()),
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
            //Column::make('id'),
            Column::make('name'),
            Column::make('display_name'),
            Column::make('description'),
            Column::make('created_at'),
            Column::make('ltpm')->visible(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Permission_' . date('YmdHis');
    }
}
