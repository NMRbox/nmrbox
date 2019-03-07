import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {environment} from '../../environments/environment';

@Component({
  selector: 'app-files',
  templateUrl: './files.component.html',
  styleUrls: ['./files.component.css']
})
export class FilesComponent implements OnInit {

  constructor(private route: ActivatedRoute) {
  }

  ngOnInit() {

    // Tabs: go to specific subsection
    this.route.params.subscribe(params => {
        window.location.href = environment.appUrl + '/files/' + params['filename'];
      }
    );
  }

}
