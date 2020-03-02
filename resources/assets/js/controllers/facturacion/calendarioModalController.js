import {erp} from '../../app.js';

erp.controller('calendarioModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','Upload','MaterialCalendarData',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, Upload, MaterialCalendarData){
    var ctrl = this;
    ctrl.calendario_general = `
                           <md-content layout='column' layout-fill  md-swipe-left='next()' md-swipe-right='prev()' style="border-radius: 0px 0px 10px 10px;">
                    <md-toolbar class="calendarioheader">
                        <div class='md-toolbar-tools' layout='row'>
                            <md-button class="md-icon-button calendar-font" ng-click='prev()' aria-label="Mes anterior">
                                <md-tooltip ng-if="::tooltips()">Mes anterior</md-tooltip>
                                &laquo;
                            </md-button>
                            <div flex></div>
                            <h2 class='calendar-md-title'><span>{% calendar.start.format(titleFormat)%}</span></h2>
                            <div flex></div>
                            <md-button class="md-icon-button calendar-font" ng-click='next()' aria-label="Siguiente mes">
                                <md-tooltip ng-if="::tooltips()">Siguiente mes</md-tooltip>
                                &raquo;
                            </md-button>
                        </div>
                    </md-toolbar>
                    <!-- agenda view -->
                    <md-content ng-if='weekLayout === columnWeekLayout' class='agenda'>
                        <div ng-repeat='week in calendar.weeks track by $index'>
                            <div ng-if="sameMonth(day)" ng-class='{"disabled" : isDisabled(day), active: active === day, "has-events": hasEvents(day) }'  class='p-0' ng-click='handleDayClick(day)' ng-repeat='day in week' layout>
                                <md-tooltip ng-if="::tooltips()">{%day | date:'dayTooltipFormat'%}</md-tooltip>
                                <div class="w-100 text-center">{% day | date:dayFormat:timezone%}</div>
                            </div>
                        </div>
                    </md-content>
                    <!-- calendar view -->
                    <md-content ng-if='weekLayout !== columnWeekLayout' flex layout="column" class='calendar'>
                        <div layout='row' class='subheader p-0 text-center'>
                            <div layout-padding class='subheader-day p-0' flex ng-repeat='day in calendar.weeks[0]'>
                            <md-tooltip ng-if="::tooltips()">{% day | date:'dayTooltipFormat'%}</md-tooltip>
                            {% day | date:dayLabelFormat%}
                            </div>
                        </div>
                        <div ng-if='week.length' ng-repeat='week in calendar.weeks track by $index' flex layout='row'>
                            <div tabindex='{% sameMonth(day) ? (day | date:dayFormat:timezone) : 0%}' class='p-0' ng-repeat='day in week track by $index' ng-click='handleDayClick(day)' flex layout layout-padding ng-class='{"disabled" : isDisabled(day), "active": isActive(day), "has-events": hasEvents(day), "md-whiteframe-12dp": hover || focus }' ng-focus='focus = true;' ng-blur='focus = false;' ng-mouseleave="hover = false" ng-mouseenter="hover = true">
                                <md-tooltip ng-if="::tooltips()">{% day | date:'dayTooltipFormat'%}</md-tooltip>
                                <div class="w-100 text-center pt-1">{% day | date:dayFormat%}</div>
                            </div>
                        </div>
                    </md-content>
                </md-content>`; 

        //ctrl.dayFormat = "d";
        ctrl.selectedDate = null;
        ctrl.firstDayOfWeek = 1;
        ctrl.disabledDays = []; 
        //ctrl.tooltips = true;
        
        ctrl.setDirection = function(direction) {
          ctrl.direction = direction;
          //console.log(ctrl.direction);
          //ctrl.dayFormat = direction === "vertical" ? "EEEE, MMMM d" : "d";
        };

        //dia clicado
        ctrl.dayClick = function(date)
        {
            ctrl.fecha = moment(date).format("DD/MM/YYY");
            //ctrl.ejercicio = moment(date).format("YYYY");
            $uibModalInstance.close({fecha: ctrl.fecha});
        };

       /* if(detalle.fechainicio != 0){
            const dateStart = moment(`${moment().format('YYYY')}-01-01`, 'YYYY-MM-DD').subtract(1, 'days');
            const dateEnd = moment(detalle.fechainicio, 'DD/MM/YYYY');
            let daysSelected = moment(dateStart).weekdaysInBetween(moment(dateEnd))
            if (daysSelected) {
                if (Array.isArray(daysSelected)) {
                    _.each(daysSelected, (d) => {
                        ctrl.disabledDays.push(moment(d).format('YYYY-MM-DD'))
                    })
                } else {
                    ctrl.disabledDays.push(moment(daysSelected).format('YYYY-MM-DD'))
                }
            }
        }*/
        

        ctrl.setDayContent = function(date) {
         return "<p></p>";
        };

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);