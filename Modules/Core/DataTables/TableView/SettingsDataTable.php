<?php

namespace Modules\Core\DataTables\TableView;

use Modules\Core\Entities\Setting;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields\Text;

class SettingsDataTable extends DataTable
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
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Modules\Core\Entities\Setting $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Setting $model)
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
            ->setTableId('settings-table')
            ->columns($this->getColumns())
            ->dom('Bfrtip')
            ->orderBy(1)
            ->select('single')
            ->responsive()
            ->pageLength(20)
            ->buttons(
                Button::make('edit')->editor('editor')->authorized(user()->isAbleTo('update-system-variable')),
                Button::make('remove')->editor('editor')->authorized(user()->isAbleTo('delete-system-variable')),
                Button::make('')->text('<i class="fas fa-sync-alt"></i>  Reload')->action('function(e, dt, node, config){ dt.draw(false); }')
            )->editor(
                Editor::make()->fields([
                    Text::make('key'),
                    Text::make('value'),
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
            Column::make('id')->visible(false),
            Column::make('key'),
            Column::make('value')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Settings_' . date('YmdHis');
    }
}
