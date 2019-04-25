import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';
import {ResponsiveService} from '../responsive.service';

@Component({
  selector: 'app-support',
  templateUrl: './support.component.html',
  styleUrls: ['./support.component.scss']
})
export class SupportComponent implements OnInit {

  tabIndex: number;

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    public responsiveService: ResponsiveService
  ) {
  }

  ngOnInit(): void {

    // Tabs: go to specific subsection
    this.route.params.subscribe(params => {
        this.tabIndex = params['index'];
        if (this.tabIndex > 0) {
          this.selectedIndexChange(this.tabIndex);
        }
      }
    );
  }


  // Tabs
  selectedIndexChange(index: number): void {
    if (!index) {
      index = 0;
    }
    this.tabIndex = index;
    this.router.navigate(['/support', index]);
  }
}
