@extends('layouts.default')

{{-- Page title --}}
@section('title')
    TRD 2
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
                    <h1>TRD 2</h1>
                    <span>NMRbox information management: CONNJUR and BMRB integration</span>
                </div>

                <div class="research-container">

                    <h2>Summary</h2>

                    <p>
                        The successful investigation of a biological system by NMR spectroscopy is a complex multi-step process, often requiring both automated and manual data analysis tools. The proposed NMRbox platform will provide the NMR spectroscopist easy access to a number of possible software solutions that address each step in the process. The challenges then facing the spectroscopist include: (1) the lack of software interoperability, (2) the ability to reproduce workflows and data flows, (3) the integration of experimental and derived data with information from public databases to generate new knowledge, and (4) the aggregation of experimental and metadata to form a deposition to a public database. The goal is to utilize knowledge of the NMRbox software ecosystem and infrastructure to develop user workflow analysis, data management, and public database query systems that address these challenges and provide support for advanced data analysis tools.&nbsp;
                    </p>
                    <p>
                        The
                        <em>
                            CONNJUR/BMRB
                        </em>
                        team has made strides toward improving software interoperability and workflow reproducibility through efficient file translation, the wrapping of third-party software at a functional level, and the capture of manual NMR spectral annotation. Driven and prioritized by the collaborating research teams and other users of the NMRbox platform, these technologies will be improved and extended to support additional software tools. Applications will be designed to analyze user activity to optimize data processing and exploration workflows. The encapsulation of metadata and quantitative information from an ongoing study of a biological system in the proposed
                        <strong>
                            <em>
                                CONNJUR
                            </em>
                        </strong>
                        data management system will provide the substrate to support both advanced automated and manual technologies for user access to
                        <strong>
                            <em>
                                BMRB (Biological Magnetic Resonance Data Bank)
                            </em>
                        </strong>
                        data and services. Ultimately, a tool will be developed to facilitate deposition of the stored data into the appropriate public database.&nbsp;
                    </p>
                    <p>
                        <h2>
                            Background
                        </h2>
                    </p>
                    <p>
                        Scientists from all disciplines are challenged to sift through the vast quantities of data stored in public archives for data relevant to their research. For the bio-NMR community, the proposed NMRbox platform (
                        <strong>
                            <a href="{{ URL::to('trd1') }}">TRD1</a>
                        </strong>
                        ) provides a rich and unique environment in which to develop tools designed to actively support novel research activities with data management, workflow analysis, and public archive search, retrieval, and deposition functionality. The goal of
                        <strong>
                            TRD2
                        </strong>
                        is to create such a set of tools through the extension of the data and workflow management capabilities of CONNJUR and the integration of BMRB resources with CONNJUR and the NMRbox platform.
                    </p>
                    <p>
                        <strong>
                            <em>
                                The Biological Magnetic Resonance Data Bank (BMRB &ndash;
                            </em>
                        </strong>
                        <a href="http://www.bmrb.wisc.edu%29/">
                            <strong>
                                <em>
                                    www.bmrb.wisc.edu)
                                </em>
                            </strong>
                        </a>
                        is the primary source of experimental NMR data world-wide1. BMRB maintains five relatively distinct, but related and integrated, archives: (1) the NMR experimental spectral parameters and derived data repository, (2) a raw spectrometer time-domain data archive, (3) the wwPDB remediated NMR restraints databases2 (DOCR - Database of Converted Restraints and FRED - Filtered Restraints Database), (4) a small molecule structure database, and (5) a NMR spectral database of standard metabolites. Additional large sets of BMRB and PDB entry validation reports including MolProbity reports and derived data (e.g., CS-Rosetta calculated structures), are available from the BMRB FTP site. The archive is designed to accommodate new developments, such as the use of images and animations to represent molecular dynamics, new validation methods, and the integration of additional external repositories like PACSY linked to BMRB entries. To foster these goals, the BMRB provides many services including: (1) NMR data deposition, (2) data validation and annotation, (3) data visualization as well as summary and statistical information derived from the primary data, (4) data archival and retrieval, and (5) development and maintenance of the computer infrastructure necessary to support these tasks. In addition, the BMRB manages the primary data format for storage and exchange of NMR data &ndash; termed NMR-STAR (
                        <a href="http://www.bmrb.wisc.edu/dictionary/).">
                            http://www.bmrb.wisc.edu/dictionary/).
                        </a>
                        NMR-STAR is derived from the STAR file format specifications defined by Hall and others3-6 as is the mmCIF format7-9 and the pdbx format that will soon replace the &lsquo;PDB format&rsquo; used by the wwPDB to archive atomic coordinate and associated metadata.&nbsp;
                    </p>
                    <p>
                        <strong>
                            <em>
                                CONNJUR Software Integration Environment
                            </em>
                        </strong>
                        <strong>
                            .
                        </strong>
                        The NMR data processing pipeline consists of four distinct phases:
                        <em>
                            Spectral Acquisition (SQ)
                        </em>
                        , the collection of NMR data in the time domain,
                        <em>
                            Spectral Reconstruction (SR)
                        </em>
                        , the converting of time-domain data to a spectral representation in the frequency domain
                        <em>
                            , Spectral Analysis (SA)
                        </em>
                        , the identification and assignment of spectral peaks, and
                        <em>
                            Biophysical Characterization (BC)
                        </em>
                        , which loosely covers all subsequent data analysis and derivation. A fifth analysis component for which software is required is that of
                        <em>
                            Molecular Visualization (MV)
                        </em>
                        .&nbsp;
                    </p>
                    <p>
                        There are currently dozens of software packages available for NMR data handling (<a href="{{ URL::to('trd1') }}">TRD1</a>). No one software tool can manage the entire NMR processing pipeline from start to finish. Software integration refers to the ability to seamlessly interchange between different software tools. In order to accomplish true integration, data must be translated through a common data model and a common data store so that regardless of the software tool employed, the user has access to the same dataset. This is the goal of the CONNJUR project.
                    </p>

                    <p>
                        <strong>
                            <em>
                                CONNJUR/BMRB integration overview.
                            </em>
                        </strong>
                        BMRB has developed APIs for the NMRbox platform and integration with CONNJUR that sit on the user&rsquo;s NMRbox desktop and allow access to BMRB relational database queries, to DEVise data visualizations 28-30, to a CS-Rosetta structure calculation server, and to a BMRB archive FASTA search engine. CONNJUR support for NMR data incorporation into a NMR-STAR compliant data model will provide the infrastructure required to support the proposed development of BMRB archive data retrieval and deposition and access to BMRB SaaS facilities for users of the NMRbox platform. These platform enhancements will dramatically ease the exploration of publicly available data, improve the quality and completeness of data depositions, and support reproducible research.&nbsp;
                    </p>

                    <h2>Innovation</h2>

                    <p>
                        <strong>
                            TRD2
                        </strong>
                        builds on the
                        <strong>
                            <a href="{{ URL::to('trd1') }}">TRD1</a>
                        </strong>
                        NMRbox VM in proposing a novel flexible and constantly evolving data management infrastructure to integrate NMRbox software applications and public database resources for the benefit of end-users. The CONNJUR/BMRB development team will be an interface between the software developers (
                        <strong>
                            CSs
                        </strong>
                        ) and the
                        <strong>
                            DBPs
                        </strong>
                        , assimilating new software tools into the CONNJUR data model to provide an efficient platform for executing biological NMR research. This relationship allows software developers to focus on solutions to computationally difficult or manual methods, while their deployed applications are utilized within the NMRbox environment. Metadata identified as necessary for reproducibility and data deposition will be modeled in the NMR-STAR data dictionary. From a NMR-STAR formatted file(s) or a CONNJUR/NMR-STAR relational database, the data can be exported in a variety of existing or developing data formats for data exchange or data deposition. Automating depositions will reduce mistakes and create more complete data depositions.&nbsp;
                    </p>

                    <h2>
                        Specific Aims
                    </h2>

                    <p>
                        <strong>
                            Aim T2.1: Extend the CONNJUR data model and CONNJUR software integration environment to capture all relevant metadata required to save the state of both an ongoing and completed biomolecular NMR study.
                        </strong>
                        The capture of all information - the raw NMR data, the software tools and protocols for computation, and the manual steps and decision-making of the spectroscopist - will significantly enhance the data processing experience. For example, this will allow the analysis and reproduction of critical steps in the workflow of a study, reuse of particularly efficient workflow components, reflection on decisions and computational steps in assessing the validity of a study, and comparison of workflow methods.
                    </p>
                    <p>
                        <strong>
                            Aim T2.2: Enable CONNJUR as a direct deposition engine for the BMRB, PDB, and the NIH metabolomics Data Repository and Coordinating Center (DRCC).
                        </strong>
                        The full CONNJUR implementation, developed as
                        <strong>
                            Aim T2.1
                        </strong>
                        , will inherently maintain all of the relevant NMRbox application metadata generated/used during a biomolecular or metabolomic NMR study. Tools will be developed to organize these data into a form that can be deposited at the appropriate public database.&nbsp;
                    </p>
                    <p>
                        <strong>
                            Aim T2.3: Construct machine-to-machine (M2M) infrastructure for future automated access to BMRB resources.
                        </strong>
                        The productivity of researchers using the NMRbox would be enhanced through automated and proactive extraction and presentation of information relevant to their research located in the BMRB archive. Infrastructure will be developed which will assist in the future integration of BMRB services.
                    </p>
                    <p class="text-center">
                        OVERVIEW OF PROPOSED NMRBOX M2M INFRASTRUCTURE
                    </p>

                    <img class="img-responsive center-block" src="{{ asset('assets/img/proposed_nmrbox_m2m_infrastructure.png') }}" alt="OVERVIEW OF PROPOSED NMRBOX M2M INFRASTRUCTURE">

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
