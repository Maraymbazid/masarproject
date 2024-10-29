 <div class="left-side-bar">
     <div class="brand-logo">
         <a href="index.html">
             <img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt="" class="dark-logo">
             <img src="{{ asset('vendors/images/deskapp-logo-white.svg') }}" alt="" class="light-logo">
         </a>
         <div class="close-sidebar" data-toggle="left-sidebar-close">
             <i class="ion-close-round"></i>
         </div>
     </div>
     <div class="menu-block customscroll">
         <div class="sidebar-menu">
             <ul id="accordion-menu">
                 {{-- start of admin dropdown  --}}
                 @if (auth()->guard('admin')->check())
                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                         </a>
                         <ul class="submenu">
                             <li><a href="index.html">Dashboard style 1</a></li>
                             <li><a href="index2.html">Dashboard style 2</a></li>
                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon dw dw-copy"></span><span class="mtext"> Classes</span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('classes.create') }}">Add class</a></li>
                             <li><a href="{{ route('classes.index') }}">All classes</a></li>

                         </ul>
                     </li>

                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon dw dw-copy"></span><span class="mtext"> Exams </span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('exams.create') }}">Add exam</a></li>

                             <li><a href="{{ route('exams.index') }}">All Exams</a></li>

                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle">
                             <span class="micon dw dw-chat3"></span><span class="mtext">Subject</span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('subjects.create') }}">Add Subject</a></li>
                             <li><a href="{{ route('subjects.index') }}">All subjects</a></li>
                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle">
                             <span class="micon fa fa-user"></span><span class="mtext">Teatcher</span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('teatchers.create') }}">Add Teatcher</a></li>
                             <li><a href="{{ route('teatchers.index') }}">All teatchers</a></li>
                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon fa fa-user"></span><span class="mtext"> supervisor</span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('supervisors.create') }}">Add supervisor</a></li>
                             <li><a href="{{ route('supervisors.index') }}">All supervisors</a></li>

                         </ul>
                     </li>
                 @endif
                 {{-- end of admin dropdown --}}

                 {{-- start of supervisor dropdown --}}
                 @if (auth()->guard('supervisor')->check())
                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon fa fa-user"></span><span class="mtext"> students </span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('download.page') }}">Add student</a></li>
                             <li><a href="{{ route('students.create') }}">Import file </a></li>


                         </ul>
                     </li>

                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon fa fa-user"></span><span class="mtext"> List of students </span>
                         </a>
                         <ul class="submenu">

                             <li><a href="{{ route('select-class-by-supervisor') }}">All students</a></li>

                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon fa fa-user"></span><span class="mtext"> List of Notes </span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('get-note-by-supervisor') }}">All Note</a></li>

                         </ul>
                     </li>
                 @endif
                 {{-- end of supervisor dropdown --}}

                 {{-- start of dropdown teachers --}}
                 @if (auth()->guard('teacher')->check())
                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon fa fa-user"></span><span class="mtext"> Notes </span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('notes.create') }}">Add note</a></li>

                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon fa fa-user"></span><span class="mtext"> Export-Import Notes </span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('export-import-notes-students') }}">Export notes</a></li>
                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon fa fa-user"></span><span class="mtext"> List of students </span>
                         </a>
                         <ul class="submenu">
                             <li><a href="{{ route('students.liste') }}">Students</a></li>

                         </ul>
                     </li>
                 @endif

                 {{-- end of dropdown teachers --}}



             </ul>
         </div>
     </div>
 </div>
 <div class="mobile-menu-overlay"></div>
