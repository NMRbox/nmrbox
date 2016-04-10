@extends('layouts.default')

{{-- Page title --}}
@section('title')
    TRD 1
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
                    <h1>TR&amp;D 1</h1>
                    <span>A software environment for bio-NMR Data Processing and Analysis: NMRbox</span>
                </div>

                <div class="research-container">

                    <h2>Summary</h2>

                    <p>
                        The broad aim of TRD1 is to utilize existing and emerging virtualization technology to simplify
                        the development, installation, distribution, and
                        maintenance of the complex software environment needed to support bio-NMR studies. This platform
                        is designed to foster the reproducibility of bio-NMR
                        studies by providing persistent access to fully configured computational resources.
                    </p>

                    <img class="img-responsive center-block" src="{{ asset('assets/img/images-trd1/users-nmrbox-developers.png') }}" alt="NMRbox users and developers">

                    <h2>Overview</h2>

                    <p>
                        Virtualization refers to methods for simulating a hardware and/or software environment.
                        Modern processors are designed with virtualization technology built-in, thereby allowing “guest”
                        virtual machines (VMs) to run at near native performance
                        on a “host” computer. The VMs may be downloaded and executed locally or accessed remotely as a cloud-based
                        Platform-as-a-Service (PaaS) through virtual
                        network computing (VNC). Virtualization is a robust technology that delivers multiple benefits: (1) a
                        zero-configuration computing platform, (2) easy access to
                        distributed computing, (3) simplified software development and maintenance on a single target
                        OS, (4) efficient sharing of computational resources, (5)
                        simplified system administration, and (6) long-term persistence of software that utilize
                        deprecated or obsolete OSs.
                    </p>

                    <h2>Innovative Ideas</h2>

                    <p>
                        NMRbox provides a persistent computing platform that both maintains access to previously
                        developed software packages and fosters reproducible research – a
                        hallmark of the scientific process that is often not achieved. The <em>spectroscopist</em>
                        benefits from a zero-configuration platform provisioned with
                        easy to discover software with zero-cost access to significant computational resources. The <em>software
                            developer</em> is able to focus development and
                        support on a single target OS with the enhanced ability to develop software tools that integrate
                        multiple primary software packages already managed by the Center.
                    </p>

                    <h2>Key Objectives</h2>

                    <p>
                        <strong>Develop the NMRbox virtual machine provisioned with software utilized in NMR
                            data processing and analysis.</strong> Software included
                        in NMRbox will be determined by community polls and the needs of the DBPs and Collaborators, in
                        consultation with the External Advisory Board (EAB).
                        Software developers will be engaged in both the provisioning process and the Center’s training
                        and dissemination activities.
                    </p>
                    <p>
                        <strong>Develop a distribution platform for the NMRbox VM and its associated resources.</strong>
                        This website will allow users and software developers to create accounts,
                        download VMs, manage individual PaaS VMs, discover software, and
                        access training information.
                    </p>
                    <p>
                        <strong>Develop a system for passing tasks that benefit from parallelization from PaaS
                            VMs to distributed computing clusters.</strong> Many NMR software applications such as those
                        performing structure calculations and maximum
                        entropy reconstructions of NMR data are embarrassingly simple to
                        parallelize across computer clusters.  We will develop tools within NMRbox to allow near
                        seamless integration between the PaaS VMs and in-house compute clusters.
                    </p>


                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
