import {Directive, ElementRef} from '@angular/core';

@Directive({
  selector: '[appPassword]'
})
export class AppPasswordDirective {
  private _shown = false;
  words = false;

  constructor(private el: ElementRef) {
    if (el.nativeElement.parentNode.nodeName.toLowerCase() === 'div') {
      this.words = true;
    }
    this.setup();
  }

  toggle(elem: HTMLElement) {
    this._shown = !this._shown;
    if (this._shown) {
      this.el.nativeElement.setAttribute('type', 'text');
      if (this.words) {
        elem.innerHTML = 'Hide password';
      } else {
        elem.setAttribute('alt', 'Hide password');
        elem.setAttribute('src', '/assets/graphics/sitewide/eye-off-outline.svg');
        elem.title = 'Hide password';
      }
    } else {
      this.el.nativeElement.setAttribute('type', 'password');
      if (this.words) {
        elem.innerHTML = 'Show password';
      } else {
        elem.setAttribute('alt', 'Show password');
        elem.setAttribute('src', '/assets/graphics/sitewide/eye.svg');
        elem.title = 'Show password';
      }
    }
  }

  setup() {
    const parent = this.el.nativeElement.parentNode;
    let elem;
    if (this.words) {
      elem = document.createElement('span');
      elem.innerHTML = `Show password`;
      elem.style.cursor = 'pointer';
      elem.style.fontWeight = 'bold';
    } else {
      elem = document.createElement('img');
      elem.src = '/assets/graphics/sitewide/eye.svg';
      elem.alt = 'Show password';
      elem.title = 'Show password';
      elem.style.width = '24px';
      elem.style.height = '24px';
      elem.style.cursor = 'pointer';
    }
    /*
    */
    elem.addEventListener('click', () => {
      this.toggle(elem);
    });
    parent.appendChild(elem);
  }
}
