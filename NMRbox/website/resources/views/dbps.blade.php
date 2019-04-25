@extends('layouts.default')

{{-- Page title --}}
@section('title')
    DBPs
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
                    <h1>Driving Biological Projects</h1>
                </div>

                <div class="research-container">

                    <h2>Summary</h2>

                    <p>
                        The purpose of DBPs is to ensure that the TRD components of the Center are directed toward solving challenges posed by ongoing, publically funded research on important biomedical problems. We have recruited a group of outstanding investigators to collaborate with the Center. The initial complement of DBPs lead by these collaborators span bio-NMR applications including protein structural biology in solution and the solid state, structural biology of RNA, NMR relaxation studies of biomolecular dynamics, and NMR-based metabolomics. While this initial complement of DBPs does not completely cover the gamut of biomedical applications of NMR, it does cover a significant range of bio-NMR applications for which computation has been enabling, on the one hand, but present challenges that can be addressed using computation as well as offering opportunities for greater advances enabled through computation. The Center actively considers new projects for inclusion as DBPs. Visit the Initiating a Collaboration page for information on establishing a new collaboration.
                    </p>
                    <h2>
                        Current Roster
                    </h2>
                    <p>
                        DBP 1. Structure biology of Herpes simplex virus (Sandra Weller, UConn Health)
                    </p>
                    <p>
                        DBP 2. Structural and functional characterization of USP7 - a promising anti-cancer drug target (Irina Bezsonova, UConn Health)
                    </p>
                    <p>
                        DBP 3. Interactions and Dynamics of Protein Assemblies involved in Translesion DNA Synthesis (Dmitry Korzhnev, UConn Health)
                    </p>
                    <p>
                        DBP 4. Ligand-Specific Structural Changes in the Vitamin D Receptor in Solution (John Markley, UW-Madison)
                    </p>
                    <p>
                        DBP 5. NMR-SAXS structure of the U4/U6 snRNA complex (Sam Butcher, UW-Madison)
                    </p>
                    <p>
                        DBP 6. Metabolomics Profiling of Bacterial Biofilms Infecting Chronic Human Wounds(Valerie Copi&eacute;, Montana)
                    </p>
                    <p>
                        DBP 7. NMR Studies of the Dynamics of Proteins and Protein/DNA Complexes (Mark Rance, Cincinnati)
                    </p>

                    <img class="img-responsive center-block" src="{{ asset('assets/img/dbps.jpeg') }}" alt="OVERVIEW OF PROPOSED NMRBOX M2M INFRASTRUCTURE">

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
