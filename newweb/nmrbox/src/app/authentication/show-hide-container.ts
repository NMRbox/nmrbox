import {Component, ContentChild} from '@angular/core';

@Component({ selector: 'show-hide-container',
    template: ''
})
export class ShowHideContainer
{
    show = false;

    @ContentChild('showhideinput') input;

    constructor() {}

    /*toggleShow()
    {
        this.show = true;
        console.log(this.input);
        if (this.show){
            this.input.nativeElement.type = 'text';
        } else {
            this.input.nativeElement.type = 'password';
        }
    }*/
}