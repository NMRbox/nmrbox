@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Meetings
    @parent
    @stop

    {{-- page level styles --}}
    @section('header_styles')
    @stop


    {{-- Page content --}}
    @section('content')
            <!-- Container Section Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">

                <div class="research-header">
                    <h1>Meetings</h1>
                    <span></span>
                </div>

                <div class="research-container">


                    <h2>Biophysical Society Meeting</h2>

                    <ul>
                        <li>&nbsp; &nbsp; <span class="bold">Date</span>: February 28 - March 1, 2016</li>
                        <li>&nbsp; &nbsp; <span class="bold">Location</span>: Los Angeles, CA</li>
                        <li>&nbsp; &nbsp; <span class="bold">Presence</span>:&nbsp;
                            <ul>
                                <li>Vendor Booth</li>
                                <li>Poster:
                                    <ul>
                                        <li>Adam Schuyler, et al.<br />
                                            &quot;NMRbox: National Center for Biomolecular NMR Data Processing and Analysis&quot;<br />
                                            &nbsp;Board LB97, February 29, 1:45 - 2:45pm, West Hall</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>&nbsp; <span class="bold">Goals</span>:
                            <ul>
                                <li>live demos</li>
                                <li>user registration</li>
                                <li>public launch of NMRbox VM</li>
                            </ul>
                        </li>
                    </ul>

                    <h2>Experimental NMR Conference</h2>

                    <ul>
                        <li>&nbsp;&nbsp; &nbsp;<span class="bold">Date</span>: April 10 - 15, 2016</li>
                        <li>&nbsp;&nbsp; &nbsp;<span class="bold">Location</span>: Pittsburgh, PA</li>
                        <li>&nbsp;&nbsp; &nbsp;<span class="bold">Presence</span>:
                            <ul>
                                <li>platform talk
                                    <ul>
                                        <li>Mark Maciejewski&nbsp;</li>
                                        <li>&quot;Towards Reproducible Computation for NMR with NMRbox&quot;</li>
                                        <li>Wednesday April 12, 10:45am - 12:30pm</li>
                                        <li>WOB - Computational Methods for &amp; by NMR, Grand 1</li>
                                    </ul>
                                </li>
                                <li>"Vendor" suite
                                    <ul>
                                        <li>NMRbox demo</li>
                                        <li>Wednesday April 12, 6 &ndash; 9pm</li>
                                        <li>King&rsquo;s Plaza&nbsp; &nbsp;</li>
                                    </ul>
                                </li>
                                <li>poster
                                    <ul>
                                        <li>Adam Schuyler, et al.</li>
                                        <li>Board 172, All Week, 2:00 - 3:45pm, Kings Garden + Grand 3-4</li>
                                        <li>&quot;NMRbox: National Center for Biomolecular NMR Data Processing and Analysis&quot;</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><span class="bold">Goals</span>:
                            <ul>
                                <li>NMRbox demo</li>
                                <li>user registration</li>
                                <li>advertise open position open</li>
                                <li>promote <a href="/workshops">June workshop</a></li>
                            </ul>
                        </li>
                    </ul>

                    <h2>Symposium on Biomolecular Structure, Dynamics and Function</h2>

                    <ul>
                        <li><span class="bold">Date</span>: April 29 - May 1, 2016</li>
                        <li><span class="bold">Location</span>: Brown University, Providence RI</li>
                        <li><span class="bold">Presence</span>:
                            <ul>
                                <li>Poster</li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
