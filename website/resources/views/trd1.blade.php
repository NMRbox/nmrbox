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
                    <h1>TRD 1</h1>
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

                    <p>
                        Virtualization refers to methods for simulating a hardware and/or software environment.
                        Virtualization was originally conceived as a means of sharing a
                        single computer among different operating systems (OSs) developed by IBM in the late 1960’s.
                        More recently, virtualization has enjoyed a resurgence as
                        modern processors are designed with virtualization technology built-in, thereby allowing “guest”
                        virtual machines (VMs) to run at near native performance
                        on a “host” computer. A supervisory program called a hypervisor abstracts the host’s resources,
                        such as CPUs, memory, and disks, and provides them to guest
                        VMs. The VMs may be downloaded and executed locally or accessed remotely as a cloud-based
                        Platform-as-a-Service (PaaS)<strong> </strong>through virtual
                        network computing. Virtualization is a robust technology that delivers multiple benefits: (1) a
                        zero-configuration computing platform, (2) easy access to
                        distributed computing, (3) simplified software development and maintenance on a single target
                        OS, (4) efficient sharing of computational resources, (5)
                        simplified system administration, and (6) long-term persistence of software that utilize
                        deprecated or obsolete OSs.
                    </p>

                    <p>
                        Linux containers are an emerging technology for virtualizing a software environment. While a VM
                        and a container both contain a guest OS and target
                        application(s) they differ substantially in how they are executed. The VM requires a hypervisor
                        to launch the guest OS and allocate host OS resources to
                        the VM, whereas a container runs as an isolated process on the host operating system, sharing
                        the host kernel with other containers and utilizing only the
                        resources necessary to run the target application(s). Without the overhead of a complete host
                        OS, a containerized application launches as fast as a
                        natively-installed application. Containers can be used in tandem with VMs, and in many ways
                        complement the advantages of VMs.
                    </p>

                    <h2>Innovation</h2>

                    <p>
                        NMRbox provides a persistent computing platform that both maintains access to previously
                        developed software packages and fosters reproducible research – a
                        hallmark of the scientific process that is often not achieved. The <em>spectroscopist</em>
                        benefits from a zero-configuration platform provisioned with
                        easy to discover software with zero-cost access to significant computational resources. The <em>software
                            developer</em> is able to focus development and
                        support on a single target OS with the enhanced ability to develop software tools that integrate
                        multiple primary software packages already managed by the
                        Center.
                    </p>

                    <h2>Specific Aims</h2>

                    <p>
                        <strong>Aim T1.1: Develop the NMRbox virtual machine provisioned with software utilized in NMR
                            data processing and analysis.</strong>
                        Development begins with constructing a master VM that contains all NMR software managed by the
                        Center. Provisioning scripts for installing the software and
                        unit tests for validating proper functionality will be developed to ensure consistency across
                        releases. As Linux container technology continues to mature,
                        NMR software packages will be encapsulated in their own container and installed within NMRbox,
                        thereby eliminating the possibility of conflicting
                        dependencies with other software packages or the host VM and freeing developers from the need to
                        support the same target OS in lockstep. Software included
                        in NMRbox will be determined by community polls and the needs of the DBPs and Collaborators, in
                        consultation with the External Advisory Board (EAB).
                        Software developers will be engaged in both the provisioning process and the Center’s training
                        and dissemination activities.
                    </p>

                    <p>
                        <strong>Aim T1.2: Develop the distribution platform for NMRbox as a standalone VM and as a
                            cloud-based Platform-as-a-Service (PaaS). </strong>
                        A web portal will be developed to allow users and software developers to create accounts,
                        download VMs, manage individual PaaS VMs, discover software, and
                        access training information. Users will be able to launch and manage their own individual PaaS
                        VMs, requiring significant development of the interface
                        between the web portal and the virtualization management system.
                    </p>

                    <p>
                        <strong>Aim T1.3: Develop a system for passing tasks that benefit from parallelization from PaaS
                            VMs to distributed computing clusters. </strong>
                        Many NMR software applications such as those performing structure calculations and maximum
                        entropy reconstructions of NMR data are embarrassingly simple to
                        parallelize across computer clusters. However, the technical hurdles and the cost of the
                        infrastructure are sufficient to discourage the general user. We
                        propose to develop tools within NMRbox to allow near seamless integration between the PaaS VMs
                        and in-house compute clusters. Applications that are
                        developed to take advantage of co-processors (graphical processing units), such as Amber and
                        hmsIST, will be sent to compute nodes equipped with attached
                        GPUs.
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
