import { Component, OnChanges, Input, trigger, state, animate, transition, style } from '@angular/core';

@Component({
  selector: '.my-fader',
  template: `
  <div [@visibilityChanged]="visibility" >
      <ng-content></ng-content>
  </div>
  `,
  animations: [
    trigger('visibilityChanged', [
      state('shown' , style({ opacity: 1 })),
      state('hidden', style({ opacity: 0, height: '0px' })),
      transition('* => *', animate('0.25s'))
    ])
  ]
})
export class FaderComponent implements OnChanges {

  @Input() isVisible : boolean = true;
  @Input() swFiltersOpen : boolean = true;
  //swFiltersOpen
  visibility = 'shown';

  ngOnChanges() {
     this.visibility = this.isVisible ? 'shown' : 'hidden';
     this.visibility = this.swFiltersOpen ? 'shown' : 'hidden';
  }
}