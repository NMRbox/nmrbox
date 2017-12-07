import {Component, ContentChild} from '@angular/core';

@Component({ selector: 'show-hide-container',
    template: `<div class="row">
                <div class="col-md-11"> 
                    <ng-content></ng-content>
                </div>
                <div class="col-md-1">
                    <a (click)="toggleShow($event)">
                        <img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEbSURBVDhP7dIxSwJhHMfxoyxCaHBpKsTAlqYWw+plaLi1uLg1+yokiFaHoKVwaWsJh8hNWiQIlzCUHIukKPv+nrsHnjsudGkQ/MIHvP89d3LPnTdvdsriGClzFG4DOrdmjia0ilN8IqdB0DbS/k/TEd5RRUKDuPbRxRhNDYJq0OwbFQ1IN+lD83tsIVQJI2iBnEEt4Qt23oHtFnY+RB6mAn5gT8o5bI+w84YGQW2412gLduDtBQfuyVckofQ4dZzAvogMtAXuNc/YhGkXL3AX2MeOpm24gbv2AfqTUOtowV14Cb1htYAD3MFdcwV9HbEtQt/YAO5Fb/iIzJ5wiKnS/pVxDe2nbqAX18MFivjz+5umFSz7P+f9b573CyCBVd0r3UMaAAAAAElFTkSuQmCC'>
                    </a>
                </div></div>`
})
export class ShowHideContainer
{
    show = false;

    @ContentChild('showhideinput') input;

    constructor() {}

    toggleShow()
    {
        this.show = !this.show;
        console.log(this.input);
        if (this.show){
            this.input.nativeElement.type = 'text';
        } else {
            this.input.nativeElement.type = 'password';
        }
    }
}