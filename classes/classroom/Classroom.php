<?php
/**
 * Classroom related functionality
 * Author: Fernando Martinez
 *
 */

class Classroom {
    private $id,$classroom = null;
    private $users = array();

    static public function createClassroom($courseid, $isopen = 1, $cname = 'Unnamed', $ctype = 2, $schoolclassid = 0){
        global $wpdb;
        if (get_current_user_id() == 0) return;
        $data = ['courseid' => $courseid, 'cname' => $cname, 'modptr' => 1,'lessonptr' => 1,'creatorid' => get_current_user_id(),'isopen' => $isopen, 'ctype' => $ctype, 'schoolclassid' => $schoolclassid];
        return $wpdb->insert( "{$wpdb->prefix}classroom", $data);
    }

    static public function deleteClassroom($classroomid) {
        global $wpdb;
        return $wpdb->query(
            $wpdb->prepare("DELETE FROM {$wpdb->prefix}classroom WHERE id = %d", $classroomid)
        );
    }

    static public function updateClassroom($classroomid, $data) {
        global $wpdb;
        $wpdb->update(
            $wpdb->prefix.'classroom', $data, array('id' => $classroomid)
        );
    }

    public function loadClassroom($id){
        global $wpdb;
        $this->id = $id;
        $this->classroom = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$wpdb->prefix}classroom WHERE id = %d", $id)
        );
        return (isset($this->classroom));
    }

    function loadCurrentLesson($action=null) {
        global $wpdb;
        if ($this->classroom['ctype']==2){
            $this->loadCourseInstance($action);
            addView("classview");
            return;
        }
        $sql = "select * from {$wpdb->prefix}posts p outer join {$wpdb->prefix}postmeta m on p.ID = m.post_id where id=%d and courseid=%d and post_type = %s";
        $mrows = DbUtil::loadMultipleRows($sql, array($this->classroom['lessonptr'], $this->classroom['courseid'], LrLmsConstants::LRLMS_LESSON));

    }

    function loadCourseInstance($action=null){
        global $wpdb;
        $rows = DbUtil::loadSingleRow("select * from {$wpdb->prefix}courseinstance where classroomid=%d", $this->classroom['id']);
        if(count($rows)>0){

            $coursename = $rows[0]['coursename'];
            if(($extpos=strpos($coursename,".xml"))!==false){
                $coursename = substr($coursename,0,$extpos);
            }
            error_log("loading course from files/courses/".$coursename."/");
            $pcourse = $this->getInstance('courses')->getClass('ParseCourse');
            $pcourse->parseXMLFile($this->navigator->getPath().'/files/courses/'.$coursename.'/'.$rows[0]['coursename']);
            $obj = $pcourse->getCourse();
            $courseMan = $this->getInstance('courses')->getClass('Courses');
            $courseMan->setCourse($coursename,$obj);
            $recName = "rec_".$this->classroom['id']."_".$_SESSION['uid']."lrc";
            if($action==null){
                $lesson = $courseMan->loadLesson($rows[0]['currlesson']);
                if($lesson != null){
                    $courseMan->getLessonHtml($lesson);
                }else{
                    $nxt = $obj->getStart();
                    $lesson = $courseMan->loadLesson($nxt);
                    $sql = "update courseinstance set currlesson='".$nxt."' where classroomid=".$this->classroom['id'];
                    $this->tbl->execStmt($sql);
                    $courseMan->getLessonHtml($lesson);
                }
            }else
                if($action=="nextlesson"){
                    $lesson = $courseMan->loadLesson($rows[0]['currlesson']);
                    $useNav = true;
                    if($lesson->hasQuestion()){
                        $studRecs = $this->loadStudentRecords($coursename,$recName);
                        $lessonRec = $studRecs->getLessonRecord($rows[0]['currlesson']);
                        error_log("curr. lesson:".$rows[0]['currlesson']." ::".$lesson->getName());
                        if($lessonRec!=null){
                            $nxt = $courseMan->getDecision($lesson,$lessonRec[0]);
                            if($nxt!=null){
                                $sql = "update courseinstance set currlesson='".$nxt."' where classroomid=".$this->classroom['id'];
                                $this->tbl->execStmt($sql);
                                $courseMan->getLessonHtml($courseMan->loadLesson($nxt));
                                $useNav = false;
                            }
                        }
                    }
                    if($useNav){
                        $nav = $lesson->getNav();
                        if($nav!=null){
                            $nxt = $nav->getNext();
                            if($nxt!=null){
                                $sql = "update courseinstance set currlesson='".$nxt."' where classroomid=".$this->classroom['id'];
                                $this->tbl->execStmt($sql);
                                $courseMan->getLessonHtml($courseMan->loadLesson($nxt));
                            }
                        }
                    }
                }else
                    if($action=="prevlesson"){
                        $lesson = $courseMan->loadLesson($rows[0]['currlesson']);
                        $nav = $lesson->getNav();
                        if($nav!=null){
                            $nxt = $nav->getPrevious();
                            if($nxt!=null){
                                $sql = "update courseinstance set currlesson='".$nxt."' where classroomid=".$this->classroom['id'];
                                $this->tbl->execStmt($sql);
                                $courseMan->getLessonHtml($courseMan->loadLesson($nxt));
                            }
                        }
                    }else
                        if($action=="answer"){

                            $lesson = $courseMan->loadLesson($rows[0]['currlesson']);
                            if(!$lesson->hasQuestion()){
                                error_log("error:trying to mark answer in lesson without question");
                                die("An internal error prevented this operation, please contact Support or the System administrator");
                            }
                            $qtype = $lesson->getQuestion()->getType();
                            if($qtype=="mcq" || $qtype=="MCQ"){
                                $ans="";$sep="";error_log("nopts:".$_POST['noptions']);
                                for($i=0;$i<$_POST['noptions'];$i++){
                                    if(isset($_POST['opt'.$i])){
                                        $ans.=$sep.$i;$sep=";;";
                                    }
                                }
                            }else if($qtype=="saq" || $qtype=="SAQ"){
                                $ans=$_POST['qans'];
                            }else
                                if($qtype=="scq" || $qtype=="SCQ"){
                                    $ans = $_POST['opt'];
                                }
                            error_log("currless:".$rows[0]['currlesson']." ans:".$ans);
                            if($ans==null || strlen($ans)==0 || $ans==";;"){
                                die("Please answer the question first");
                            }
                            $score = $courseMan->markQuestion($lesson->getQuestion(), $ans);
                            $fbk = "<br />".$courseMan->getErrorList();
                            $studRecs = $this->loadStudentRecords($coursename,$recName);
                            $studRecs->setLessonRecord($rows[0]['currlesson'],$score,$ans,$fbk);
                            $this->saveStudentRecords($coursename,$recName,$studRecs);
                            die("Your score for this question is ".$score.$fbk);
                        }
        }else{
            $_REQUEST['feedback'] = "The classroom content could not be loaded. Please try again later";
            error_log("Error loading [instance] lesson for classroom ".$this->classroom['id']." lesson ptr is ".$this->classroom['lessonptr']);
        }
    }

}
