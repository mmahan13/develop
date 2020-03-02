<div class="modal-header">
	<h5 class="modal-title" id="modal-title"></h5>
</div>
<div class="modal-body" id="modal-body">
    <div class="form-group">
     <calendar-md flex layout layout-fill
                              timezone="es"
                              on-day-click="$ctrl.dayClick"
                              title-format="'MMMM YYYY'"
                              template="$ctrl.calendario_general"
                              ng-model='$ctrl.selectedDate'
                              day-format="'d'"
                              start-date-of-month="1"
                              day-label-format="'EEE'"
                              day-label-tooltip-format="'EEEE'"
                              day-tooltip-format="'fullDate'"
                              week-starts-on="$ctrl.firstDayOfWeek"
                              day-content="$ctrl.setDayContent"
                              disabled-selection-days="$ctrl.disabledDays"
                              >
                  </calendar-md>
                  <!--disable-future-selection="false"-->
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" ng-click="$ctrl.cancel()">Cerrar</button>
</div>