<?php
class Moderator extends Users
{
    private $idModerator;


    public function getApprovedComment(): array
    {
        return $this->getRelatedEntities("Comment");
    }

    public function setApprovedComment(Comment $c)
    {
        $this->setRelatedEntity($c);
    }

    /**
     * Get the value of idModerator
     */
    public function getIdModerator()
    {
        return $this->idModerator;
    }

    public function getNbApprovedComment()
    {
        $result = 0;
        $approvedComments = [];
        foreach ($this->getApprovedComment() as $comment) {
            if ($comment->getFlag() == "a") {
                $approvedComments[] = $comment;
            }
        }
        return sizeof($approvedComments);
    }

    public function getNbBlockedComment()
    {
        $result = 0;
        $blockedComments = [];
        foreach ($this->getApprovedComment() as $comment) {
            if ($comment->getFlag() == "b") {
                $blockedComments[] = $comment;
            }
        }
        return sizeof($blockedComments);
    }

    /**
     * Set the value of idModerator
     *
     * @return  self
     */
    public function setIdModerator($idModerator)
    {
        $this->idModerator = $idModerator;

        return $this;
    }
}
