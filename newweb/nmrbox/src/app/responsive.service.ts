import {Injectable} from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ResponsiveService {

  isMobile: boolean;
  columns: number;

  constructor() {
    this.columns = (window.innerWidth <= 540) ? 1 : 2;
    this.isMobile = this.columns === 1;

    window.addEventListener('resize', (event) => {
      this.columns = ((event.target as Window).innerWidth <= 540) ? 1 : 2;
      this.isMobile = this.columns === 1;
    });
  }
}
