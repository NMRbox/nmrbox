import {Injectable} from '@angular/core';
import {environment} from '../environments/environment';
import {MatSnackBar, MatSnackBarRef, SimpleSnackBar} from '@angular/material';

@Injectable({
  providedIn: 'root'
})
export class ResponsiveService {

  isMobile: boolean;
  columns: number;
  snackBarRef: MatSnackBarRef<SimpleSnackBar>;

  constructor(private snackBar: MatSnackBar) {
    this.columns = (window.innerWidth <= 500) ? 1 : 2;
    this.isMobile = this.columns === 1;

    setTimeout(() => {
      if (this.isMobile) {
        this.snackBarRef = this.snackBar.open('This site is not yet optimized for mobile devices.', 'View mobile site');

        this.snackBarRef.onAction().subscribe(() => {
          window.location.href = environment.mobileURL;
        });
      }
    }, 100);

    window.addEventListener('resize', (event) => {
      this.columns = ((event.target as Window).innerWidth <= 500) ? 1 : 2;
      if (this.columns > 1) {
        this.snackBarRef.dismiss();
      } else {
        this.snackBarRef = this.snackBar.open('This site is not yet optimized for mobile devices.', 'View mobile site');
        this.snackBarRef.onAction().subscribe(() => {
          window.location.href = environment.mobileURL;
        });
      }
    });
  }
}
