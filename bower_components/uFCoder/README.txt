Instructions for a proper use of the project:

-Development:

  To build this project successfully follow this steps:
    * First delete the build directory of the project (if you use NetBeans ,it will be the 'dist' folder).
	* Start the building of the project.
    * After the build is done without errors,copy the uFr Simple.html file from the \html directory 
	  to the build folder ('dist').
    
-Before starting this applet:

    Checks the java version on your machine( in cmd "java -version").
	
    -If you run java 1.8 or higher:
	    *In java 1.8 are new security settings,and because of the that you need to add the url(path) of the applet page
		 to an exception list.
		 First open the uFr Simple.html file from the build folder in a browser.
		 After that open the java configure application ,select the 'Security' tab,check the 'High' radio button,
		 and add the url from the browser to the site list.After the settings are saved close the browser and open the uFr Simple.html again.
		 
		*The next step is to copy the required .dll(on Windows), .so(on Linux) or dyn.lib (OS X) files to the \bin folder of the jre(java) that the
		 browser is using(32 or 64,check the browser version).
	
    -If you run java 1.7 or lower ,none of the previous steps are necessary,just copy the required library(.dll)
       to the System32 folder in windows.  	 
	   
NOTE:
  After every release of a new version of java, a update of the running java virtual machine is required.
  If  Chrome is used ,since version 42 , NPAPI is by default disabled and has to be enabled manual.
  To enable NPAPI , open this url chrome: flags/#enable-npapi in chrome and enable the NPAPI option.After the restart the browser. 	 
	 
		 
TROUBLESHOOTING:
   If the applet is not able to start ,clear the browser cache and delete the cached java files.Open the java control panel,    
   open General->Settings->Delete Files (Delete cached Applications and Applets) ,and confirm the deleting.After that remove the url form the Exception list ,and add it again.
   Restart the browser and try again.
		
    