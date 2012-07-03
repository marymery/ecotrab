/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package BusinessLayer;

import dataTier.Entities.EpaTasasOcup;
import dataTier.HibernateUtil;
import java.util.List;
import org.hibernate.Query;
import org.hibernate.Session;   

/**
 *
 * @author PC
 */
public class EPATasasOcupRepository {
    

    Session session = null;

    public EPATasasOcupRepository() {
        this.session = HibernateUtil.getSessionFactory().getCurrentSession();
    }
    
    public List getEpaTasasOcupacion() {
        
        List<EpaTasasOcup> epatasasocup = null;
        try {
            org.hibernate.Transaction tx = session.beginTransaction();
            Query q = session.createQuery ("from EpaTasasOcup");
            epatasasocup = (List<EpaTasasOcup>) q.list();
            
        } catch (Exception e) {
            e.printStackTrace();
        }
        return epatasasocup;
    }

}

